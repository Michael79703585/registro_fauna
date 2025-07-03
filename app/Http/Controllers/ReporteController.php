<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Fauna;
use App\Models\Institucion;
use App\Models\Evento;
use App\Models\Transferencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FaunasExport;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Reporte::with('institucion', 'faunas');

        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->institucion_id) {
            $query->where('institucion_id', $request->institucion_id);
        }

        $reportes = $query->orderByDesc('created_at')->paginate(10);
        $instituciones = Institucion::orderBy('nombre')->get();

        return view('reportes.index', compact('reportes', 'instituciones'));
    }

    public function create()
    {
        $categorias = ['Registros', 'Nacimiento', 'Deceso', 'Fuga', 'Transferidos', 'Recepciones'];
        $grupos = ['Mamiferos', 'Aves', 'Reptiles', 'Anfibios', 'Peces'];
        $datos_poblacion = [];

        // Inicializar array
        foreach ($categorias as $categoria) {
            foreach ($grupos as $grupo) {
                $datos_poblacion[$categoria][$grupo] = 0;
            }
        }

        // 1. Registros
        $registros = Fauna::select('tipo_animal', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo_animal')->get();
        $this->agregarConteo($datos_poblacion, 'Registros', $registros, $grupos);

        // 2. Nacimientos
        $nacimientos = Evento::join('faunas', 'eventos.fauna_id', '=', 'faunas.id')
            ->whereHas('tipoEvento', fn($q) => $q->where('nombre', 'nacimiento'))
            ->select('faunas.tipo_animal', DB::raw('COUNT(*) as total'))
            ->groupBy('faunas.tipo_animal')->get();
        $this->agregarConteo($datos_poblacion, 'Nacimiento', $nacimientos, $grupos);

        // 3. Decesos
        $decesos = Evento::join('faunas', 'eventos.fauna_id', '=', 'faunas.id')
            ->whereHas('tipoEvento', fn($q) => $q->where('nombre', 'deceso'))
            ->select('faunas.tipo_animal', DB::raw('COUNT(*) as total'))
            ->groupBy('faunas.tipo_animal')->get();
        $this->agregarConteo($datos_poblacion, 'Deceso', $decesos, $grupos);

        // 4. Fugas
        $fugas = Evento::join('faunas', 'eventos.fauna_id', '=', 'faunas.id')
            ->whereHas('tipoEvento', fn($q) => $q->where('nombre', 'fuga'))
            ->select('faunas.tipo_animal', DB::raw('COUNT(*) as total'))
            ->groupBy('faunas.tipo_animal')->get();
        $this->agregarConteo($datos_poblacion, 'Fuga', $fugas, $grupos);

        // 5. Transferidos
        $transferidos = Transferencia::join('faunas', 'transferencias.fauna_id', '=', 'faunas.id')
            ->where('tipo_transferencia', 'transferido')
            ->select('faunas.tipo_animal', DB::raw('COUNT(*) as total'))
            ->groupBy('faunas.tipo_animal')->get();
        $this->agregarConteo($datos_poblacion, 'Transferidos', $transferidos, $grupos);

        // 6. Recepciones
        $recepciones = Transferencia::join('faunas', 'transferencias.fauna_id', '=', 'faunas.id')
            ->where('tipo_transferencia', 'recepcion')
            ->select('faunas.tipo_animal', DB::raw('COUNT(*) as total'))
            ->groupBy('faunas.tipo_animal')->get();
        $this->agregarConteo($datos_poblacion, 'Recepciones', $recepciones, $grupos);

        $tipo = 'Población';
        $fecha_inicio = now()->startOfMonth()->toDateString();
        $fecha_fin = now()->endOfMonth()->toDateString();
        $institucion = Auth::user()->institucion ?? null;

        return view('reportes.create', compact(
            'datos_poblacion', 'tipo', 'fecha_inicio', 'fecha_fin', 'institucion'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'datos_poblacion' => 'required|json',
        ]);

        $reporte = Reporte::create([
            'tipo' => 'Población',
            'institucion_id' => Auth::user()->institucion_id ?? null,
            'user_id' => Auth::id(),
            'datos' => $request->input('datos_poblacion'),
            'fecha_inicio' => now()->startOfMonth(),
            'fecha_fin' => now()->endOfMonth(),
        ]);

        return redirect()->route('reportes.show', $reporte->id)
            ->with('success', 'Reporte generado correctamente.');
    }

    public function show($id)
    {
        $reporte = Reporte::findOrFail($id);

        $faunas = Fauna::where('institucion_remitente', $reporte->institucion->nombre)
            ->when($reporte->fecha_inicio, fn($q) => $q->whereDate('fecha_recepcion', '>=', $reporte->fecha_inicio))
            ->when($reporte->fecha_fin, fn($q) => $q->whereDate('fecha_recepcion', '<=', $reporte->fecha_fin))
            ->get();

        return view('reportes.show', compact('reporte', 'faunas'));
    }

    public function exportPDF($id)
    {
        $reporte = Reporte::findOrFail($id);

        $faunas = Fauna::where('institucion_remitente', $reporte->institucion->nombre)
            ->when($reporte->fecha_inicio, fn($q) => $q->whereDate('fecha_recepcion', '>=', $reporte->fecha_inicio))
            ->when($reporte->fecha_fin, fn($q) => $q->whereDate('fecha_recepcion', '<=', $reporte->fecha_fin))
            ->get();

        $pdf = Pdf::loadView('reportes.pdf', compact('faunas', 'reporte'))
            ->setPaper('legal', 'landscape');

        return $pdf->download("reporte_fauna_{$reporte->id}.pdf");
    }

    public function exportExcel($id)
    {
        $reporte = Reporte::findOrFail($id);

        $faunas = Fauna::where('institucion_remitente', $reporte->institucion->nombre)
            ->when($reporte->fecha_inicio, fn($q) => $q->whereDate('fecha_recepcion', '>=', $reporte->fecha_inicio))
            ->when($reporte->fecha_fin, fn($q) => $q->whereDate('fecha_recepcion', '<=', $reporte->fecha_fin))
            ->get();

        return Excel::download(new FaunasExport($faunas), "reporte_fauna_{$reporte->id}.xlsx");
    }

    private function agregarConteo(&$datos_poblacion, $categoria, $datos, $grupos)
    {
        foreach ($datos as $d) {
            if (in_array($d->tipo_animal, $grupos)) {
                $datos_poblacion[$categoria][$d->tipo_animal] = (int)$d->total;
            }
        }
    }
    public function previewPDF($id)
{
    $reporte = Reporte::findOrFail($id);

    $faunas = Fauna::where('institucion_remitente', $reporte->institucion->nombre)
        ->when($reporte->fecha_inicio, fn($q) => $q->whereDate('fecha_recepcion', '>=', $reporte->fecha_inicio))
        ->when($reporte->fecha_fin, fn($q) => $q->whereDate('fecha_recepcion', '<=', $reporte->fecha_fin))
        ->get();

    $pdf = Pdf::loadView('reportes.pdf', compact('faunas', 'reporte'))
        ->setPaper('legal', 'landscape');

    // Mostrar PDF en navegador (inline)
    return $pdf->stream("reporte_fauna_{$reporte->id}.pdf");
}

}
