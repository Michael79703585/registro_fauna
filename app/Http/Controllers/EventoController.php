<?php

namespace App\Http\Controllers;

use App\Models\{Evento, Fauna, TipoEvento, Institucion};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\EventosExport;
use Maatwebsite\Excel\Facades\Excel;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $eventos = Evento::where('institucion_id', Auth::user()->institucion_id)->latest()->paginate(10);
        return view('eventos.index', compact('eventos'));
    }

    public function create($tipo = null)
    {
        $usuario = Auth::user();

        $faunas = Fauna::where(function($query) use ($usuario) {
            $query->where('user_id', $usuario->id)
                ->orWhereIn('id', function ($subquery) {
                    $subquery->select('fauna_id')
                        ->from('transferencias')
                        ->where('estado', 'aceptado');
                })
                ->orWhereIn('user_id', function($subquery) use ($usuario) {
                    $subquery->select('id')
                        ->from('users')
                        ->where('institucion_id', $usuario->institucion_id);
                });
        })->get();

        $tiposEvento = TipoEvento::all();
        $instituciones = Institucion::all();

        $faunasExtendidas = $faunas->map(function ($fauna) {
            return [
                'codigo' => $fauna->codigo,
                'especie' => $fauna->especie,
                'nombre_comun' => $fauna->nombre_comun,
                'sexo' => $fauna->sexo,
                'origen' => 'fauna',
            ];
        });

        $eventosNacimiento = Evento::whereHas('tipoEvento', function ($q) {
                $q->where('nombre', 'Nacimiento');
            })
            ->where(function($query) use ($usuario) {
                $query->where('user_id', $usuario->id)
                    ->orWhereIn('fauna_id', function ($q) {
                        $q->select('fauna_id')
                            ->from('transferencias')
                            ->where('estado', 'aceptado');
                    })
                    ->orWhereIn('user_id', function($q) use ($usuario){
                        $q->select('id')
                            ->from('users')
                            ->where('institucion_id', $usuario->institucion_id);
                    });
            })
            ->get(['codigo', 'especie', 'nombre_comun', 'sexo']);

        $eventosExtendidos = $eventosNacimiento->map(function ($evento) {
            return [
                'codigo' => $evento->codigo,
                'especie' => $evento->especie,
                'nombre_comun' => $evento->nombre_comun ?? null,
                'sexo' => $evento->sexo ?? null,
                'origen' => 'evento',
            ];
        });

        $animalesDisponibles = $faunasExtendidas
            ->concat($eventosExtendidos)
            ->unique('codigo')
            ->values();

        $tipo = $tipo ? ucfirst(strtolower($tipo)) : null;
        $codigoNuevo = null;

        if ($tipo === 'Nacimiento') {
            $tipoEventoNacimiento = TipoEvento::where('nombre', 'Nacimiento')->first();
            if ($tipoEventoNacimiento) {
                $codigoNuevo = $this->generarCodigoNacimiento($tipoEventoNacimiento->id);
            }
        }

        return view(
            'eventos.create' . ($tipo ? '_' . strtolower($tipo) : ''),
            compact(
                'faunas',
                'tiposEvento',
                'instituciones',
                'tipo',
                'codigoNuevo',
                'animalesDisponibles'
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
        'senas_particulares' => 'nullable|string',
    'codigo_padres' => 'nullable|string',
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
                'fecha_ingreso' => now(),
                'estado_general' => $validated['estado_general'] ?? 'Activo',
            ]
        );
    }

    return redirect()->route('eventos.index')->with('success', 'Evento registrado exitosamente.');
}

   public function show($id)
{
    $evento = Evento::with('fauna', 'tipoEvento', 'institucion')
                    ->findOrFail($id);

    // Control de acceso
    if ($evento->institucion_id !== Auth::user()->institucion_id) {
        abort(403);
    }

    // Validación opcional para visualizar todo en desarrollo
    // dd($evento); 

    return view('eventos.show', compact('evento'));
}


    public function edit($id)
    {
        $evento = Evento::findOrFail($id);

        if ($evento->institucion_id !== Auth::user()->institucion_id) {
            abort(403);
        }

        $faunas = Fauna::all();
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

        $eventos = Evento::with('tipoEvento', 'fauna', 'institucion')
            ->where('institucion_id', Auth::user()->institucion_id)
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
        $query = Evento::with(['fauna', 'tipoEvento', 'institucion'])->where('institucion_id', Auth::user()->institucion_id);

        if ($request->filled('tipo')) {
            $query->whereHas('tipoEvento', function ($q) use ($request) {
                $q->where('nombre', $request->input('tipo'));
            });
        }

        if ($request->filled('codigo')) {
            $query->where('codigo', 'like', '%' . $request->input('codigo') . '%');
        }

        $eventos = $query->paginate(20);
        $tiposEvento = TipoEvento::all();

        return view('eventos.todos', compact('eventos', 'tiposEvento'));
    }

    public function exportarPDFEvento($id)
    {
        $evento = Evento::with('fauna', 'tipoEvento', 'institucion')->findOrFail($id);

        if ($evento->institucion_id !== Auth::user()->institucion_id) {
            abort(403);
        }

        $pdf = Pdf::loadView('eventos.reporte_evento_pdf', compact('evento'));

        $nombreArchivo = 'evento_' . Str::slug($evento->codigo) . '.pdf';
        return $pdf->download($nombreArchivo);
    }

    // Función para generar código único para nacimiento
   protected function generarCodigoNacimiento($tipoEventoId)
{
    // Obtener la institución del usuario autenticado
    $institucion = Auth::user()->institucion;

    // Obtener las siglas o iniciales (si tienes un campo 'siglas', úsalo, si no, generamos de nombre)
    $siglas = $institucion->siglas ?? null;

    if (!$siglas) {
        // Si no hay siglas, tomar iniciales de las primeras palabras del nombre
        $nombreInstitucion = $institucion->nombre ?? 'XXX';
        $palabras = explode(' ', strtoupper($nombreInstitucion));
        $siglas = '';
        foreach ($palabras as $palabra) {
            $siglas .= substr($palabra, 0, 1);
        }
        $siglas = substr($siglas, 0, 3); // limitar a 3 letras
    }

    // Buscar el último código que empieza con esas siglas + NAC-
    $ultimoEvento = Evento::where('tipo_evento_id', $tipoEventoId)
        ->where('codigo', 'like', $siglas . '-NAC-%')
        ->orderBy('id', 'desc')
        ->first();

    if (!$ultimoEvento) {
        return $siglas . '-NAC-0001';
    }

    // Extraer el número del último código
    $ultimoCodigo = $ultimoEvento->codigo;
    // Ejemplo de código: ABC-NAC-0023
    // Extraemos el número final
    $numero = (int) substr($ultimoCodigo, strrpos($ultimoCodigo, '-') + 1);
    $nuevoNumero = $numero + 1;

    return $siglas . '-NAC-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
}

public function exportarExcel(Request $request)
{
    $tipo = $request->get('tipo');

    $eventos = Evento::with('tipoEvento', 'fauna', 'institucion')
        ->where('institucion_id', Auth::user()->institucion_id)
        ->when($tipo, function($query) use ($tipo) {
            $query->whereHas('tipoEvento', function($q) use ($tipo){
                $q->where('nombre', $tipo);
            });
        })
        ->orderBy('fecha', 'desc')
        ->get();

    return Excel::download(new EventosExport($eventos), 'eventos.xlsx');
}



}
