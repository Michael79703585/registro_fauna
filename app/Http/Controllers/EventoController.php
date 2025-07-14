<?php

namespace App\Http\Controllers;

use App\Models\{Evento, Fauna, TipoEvento, Institucion};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\EventosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

class EventoController extends Controller
{

    public function index(Request $request)
    {
        $eventos = Evento::where('user_id', Auth::id())->latest()->paginate(10);
        return view('eventos.index', compact('eventos'));
    }

    public function create(Request $request, $tipo = null)
{
    $user = Auth::user();
    $institucion_id = $user->institucion_id;
    
    $usuariosInstitucionIds = User::where('institucion_id', $institucion_id)->pluck('id');

    $filtroCodigo = $request->input('codigo');
    $filtroEspecie = $request->input('especie');

    $faunasQuery = Fauna::whereIn('user_id', $usuariosInstitucionIds);

    if ($filtroCodigo) {
        $faunasQuery->where('codigo', 'like', "%{$filtroCodigo}%");
    }
    if ($filtroEspecie) {
        $faunasQuery->where('especie', 'like', "%{$filtroEspecie}%");
    }
    $faunas = $faunasQuery->get();

    $eventosNacimientoQuery = Evento::whereHas('tipoEvento', function ($q) {
        $q->where('nombre', 'Nacimiento');
    })->whereIn('user_id', $usuariosInstitucionIds);

    if ($filtroCodigo) {
        $eventosNacimientoQuery->where('codigo', 'like', "%{$filtroCodigo}%");
    }
    if ($filtroEspecie) {
        $eventosNacimientoQuery->where('especie', 'like', "%{$filtroEspecie}%");
    }
    $eventosNacimiento = $eventosNacimientoQuery->get(['codigo', 'especie']);

    // Mapeos para la vista
    $faunasExtendidas = $faunas->map(function ($fauna) {
        return [
            'codigo' => $fauna->codigo,
            'especie' => $fauna->especie,
            'nombre_comun' => $fauna->nombre_comun,
            'sexo' => $fauna->sexo,
            'origen' => 'fauna',
        ];
    });

    $eventosExtendidos = $eventosNacimiento->map(function ($evento) {
        return [
            'codigo' => $evento->codigo,
            'especie' => $evento->especie,
            'origen' => 'evento',
        ];
    });

    $animalesDisponibles = $faunasExtendidas->concat($eventosExtendidos);

    $tiposEvento = TipoEvento::all();
    $instituciones = Institucion::all();

    return view(
        'eventos.create' . ($tipo ? "_{$tipo}" : ""),
        compact(
            'faunas',
            'tiposEvento',
            'instituciones',
            'animalesDisponibles',
            'tipo',
            'filtroCodigo',
            'filtroEspecie'
        )
    );
}


    public function store(Request $request)
    {
        $tipoEventoId = $request->input('tipo_evento_id');
        $tipoEvento = TipoEvento::find($tipoEventoId);

        if (!$tipoEvento) {
            return back()->withErrors(['tipo_evento_id' => 'Tipo de evento no válido'])->withInput();
        }

        $tipoNombre = strtolower($tipoEvento->nombre);
        $codigoAnimal = $request->input('codigo_animal') ?? $request->input('codigo');

        // Si es fuga o deceso, obtener datos del evento de nacimiento o fauna
        if (in_array($tipoNombre, ['fuga', 'deceso']) && $codigoAnimal) {
            $fauna = Fauna::where('codigo', $codigoAnimal)->first();

            if (!$fauna) {
                $eventoNacimiento = Evento::where('codigo', $codigoAnimal)
                    ->whereHas('tipoEvento', fn($q) => $q->where('nombre', 'nacimiento'))
                    ->latest('fecha')
                    ->first();

                if ($eventoNacimiento) {
                    $fauna = $eventoNacimiento;
                }
            }

            if ($fauna) {
                $request->merge([
                    'especie' => $request->input('especie') ?? $fauna->especie,
                    'nombre_comun' => $request->input('nombre_comun') ?? $fauna->nombre_comun,
                    'sexo' => $request->input('sexo') ?? $fauna->sexo,
                    'codigo' => $codigoAnimal,
                ]);
            } else {
                return back()->withErrors(['codigo_animal' => 'No se encontró un animal con ese código.'])->withInput();
            }
        }

        // Validación general (adaptable según tipo)
        $validated = $request->validate([
            'tipo_evento_id' => 'required|exists:tipo_eventos,id',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'especie' => 'nullable|string',
            'nombre_comun' => 'nullable|string',
            'causas_deceso' => 'nullable|string',
            'descripcion_fuga' => 'nullable|string|max:1000',
            'codigo_animal' => 'nullable|string',
            'codigo' => 'nullable|string',
            'sexo' => 'nullable|string',
            'tratamientos_realizados' => 'nullable|string',
            'estado_general' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['institucion_id'] = Auth::user()->institucion_id ?? null;

        // Generar código para nacimiento si no se proporciona
        if ($tipoNombre === 'nacimiento' && empty($validated['codigo'])) {
            $validated['codigo'] = $this->generarCodigoNacimiento($tipoEvento->id);
        }

        // Prevenir duplicados para fuga/deceso
        if (in_array($tipoNombre, ['fuga', 'deceso'])) {
            // Asignar código si solo hay código_animal y código está vacío
            if (empty($validated['codigo']) && !empty($validated['codigo_animal'])) {
                $validated['codigo'] = $validated['codigo_animal'];
            }

            // Ahora sí validar que existe para evitar error
            if (empty($validated['codigo'])) {
                return back()->withErrors(['codigo' => 'El código es requerido para eventos de ' . $tipoNombre])->withInput();
            }

            if (Evento::where('codigo', $validated['codigo'])->where('tipo_evento_id', $tipoEvento->id)->exists()) {
                return back()->withErrors(['codigo' => 'Este animal ya tiene un evento de ' . $tipoNombre])->withInput();
            }

            // Sufijo para distinguir eventos posteriores
            $sufijo = strtoupper(substr($tipoNombre, 0, 3)); // FUG o DEC
            $validated['codigo'] = $validated['codigo'] . '-' . $sufijo;
        }

        // Guardar imagen si hay
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('eventos', 'public');
        }

        // Crear evento
        Evento::create($validated);

        // Si es nacimiento, actualizar/crear fauna
        if ($tipoNombre === 'nacimiento') {
            Fauna::updateOrCreate(
                ['codigo' => $validated['codigo']],
                [
                    'especie' => $validated['especie'],
                    'nombre_comun' => $validated['nombre_comun'],
                    'sexo' => $validated['sexo'] ?? 'Indeterminado',
                    'user_id' => Auth::id(),
                    'institucion_id' => Auth::user()->institucion_id ?? null,
                    'fecha_ingreso' => now(),
                    'estado_general' => $validated['estado_general'] ?? 'Activo',
                ]
            );
        }

        return redirect()->route('eventos.index')->with('success', 'Evento registrado exitosamente.');
    }

    public function show($id)
    {
        $evento = Evento::with('fauna', 'tipoEvento', 'institucion')->findOrFail($id);

        if ($evento->institucion_id !== Auth::user()->institucion_id) {
            abort(403);
        }

        return view('eventos.show', compact('evento'));
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);

        if ($evento->institucion_id !== Auth::user()->institucion_id) {
            abort(403);
        }

        $institucionId = Auth::user()->institucion_id;

        $faunas = Fauna::where('institucion_id', $institucionId)->get();
        $tiposEvento = TipoEvento::all();
        $tipo = ucfirst(strtolower($evento->tipoEvento->nombre));

        return view("eventos.edit_{$tipo}", compact('evento', 'faunas', 'tiposEvento', 'tipo'));
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        if ($evento->institucion_id !== Auth::user()->institucion_id) {
            abort(403, 'No tienes permiso para editar este evento.');
        }

        $tipoEvento = TipoEvento::find($request->input('tipo_evento_id'));
        if (!$tipoEvento) {
            return back()->withErrors(['tipo_evento_id' => 'Tipo de evento no válido'])->withInput();
        }

        $validated = $this->validateEvento($request, $tipoEvento->nombre);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('eventos', 'public');
        }

        if (strtolower($tipoEvento->nombre) === 'fuga') {
            $validated['codigo'] = $validated['codigo_animal'];
        }

        if (strtolower($tipoEvento->nombre) === 'nacimiento' && empty($validated['codigo'])) {
            $validated['codigo'] = $evento->codigo;
        }

        $evento->update($validated);

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);

        if ($evento->institucion_id !== Auth::user()->institucion_id) {
            abort(403);
        }

        $evento->delete();

        return redirect()->route('eventos.index')->with('success', 'Evento eliminado correctamente.');
    }

    public function exportarPDF(Request $request)
    {
        $tipoNombre = $request->get('tipo');
        $institucionId = Auth::user()->institucion_id;

        $eventos = Evento::with('tipoEvento', 'fauna', 'institucion')
            ->where('institucion_id', $institucionId)
            ->when($tipoNombre, function ($query) use ($tipoNombre) {
                $query->whereHas('tipoEvento', function ($q) use ($tipoNombre) {
                    $q->where('nombre', $tipoNombre);
                });
            })
            ->orderBy('fecha', 'desc')
            ->get();

        $pdf = Pdf::loadView('eventos.reporte_pdf', compact('eventos'));

        $nombreArchivo = 'reporte_eventos' . ($tipoNombre ? "_{$tipoNombre}" : '') . '.pdf';
        return $pdf->download($nombreArchivo);
    }

    public function todos(Request $request)
{
    $institucionId = Auth::user()->institucion_id;

    $query = Evento::with('tipoEvento', 'fauna')
        ->where('institucion_id', $institucionId);

    if ($request->filled('fecha_inicio')) {
        $query->where('fecha', '>=', $request->fecha_inicio);
    }

    if ($request->filled('fecha_fin')) {
        $query->where('fecha', '<=', $request->fecha_fin);
    }

    if ($request->filled('tipo')) {
        $query->whereHas('tipoEvento', function ($q) use ($request) {
            $q->where('nombre', $request->tipo);
        });
    }

    $eventos = $query->latest()->paginate(15);

    $tiposEvento = TipoEvento::all();  // <-- Aquí cargas los tipos

    return view('eventos.todos', compact('eventos', 'tiposEvento'));  // <-- Y los envías a la vista
}


    public function exportarExcel(Request $request)
    {
        $institucionId = Auth::user()->institucion_id;
        $tipo = $request->input('tipo');

        $query = Evento::with('tipoEvento', 'fauna')
            ->where('institucion_id', $institucionId);

        if ($tipo) {
            $query->whereHas('tipoEvento', fn($q) => $q->where('nombre', $tipo));
        }

        $eventos = $query->get();

        return Excel::download(new EventosExport($eventos), 'eventos.xlsx');
    }

    private function generarCodigoNacimiento($tipoEventoId)
    {
        $ultimoEvento = Evento::where('tipo_evento_id', $tipoEventoId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$ultimoEvento || empty($ultimoEvento->codigo)) {
            return 'NAC-0001';
        }

        $codigo = $ultimoEvento->codigo;
        preg_match('/(\d+)$/', $codigo, $matches);

        if (!empty($matches)) {
            $numero = intval($matches[1]) + 1;
            return 'NAC-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
        }

        return 'NAC-0001';
    }

    private function validateEvento(Request $request, $tipoNombre)
    {
        $rules = [
            'tipo_evento_id' => 'required|exists:tipo_eventos,id',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'especie' => 'nullable|string',
            'nombre_comun' => 'nullable|string',
            'causas_deceso' => 'nullable|string',
            'descripcion_fuga' => 'nullable|string|max:1000',
            'codigo_animal' => 'nullable|string',
            'codigo' => 'nullable|string',
            'sexo' => 'nullable|string',
            'tratamientos_realizados' => 'nullable|string',
            'estado_general' => 'nullable|string',
        ];

        return $request->validate($rules);
    }
}

