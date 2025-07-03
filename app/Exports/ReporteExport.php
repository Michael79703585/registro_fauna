<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Transferencia;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function historialClinicoReporte(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $historial = HistorialClinico::whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])->get();

        // Crear registro de reporte
        Reporte::create([
            'tipo' => 'Historial Clínico',
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        if ($request->format == 'pdf') {
            // Generar PDF
            $pdf = Pdf::loadView('reportes.historial_clinico_pdf', compact('historial'));
            return $pdf->download('reporte_historial_clinico.pdf');
        }

        // Generar Excel
        return Excel::download(new \App\Exports\HistorialClinicoExport($historial), 'reporte_historial_clinico.xlsx');
    }

    public function transferenciaReporte(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $transferencias = Transferencia::whereBetween('fecha_transferencia', [$request->fecha_inicio, $request->fecha_fin])->get();

        // Crear registro de reporte
        Reporte::create([
            'tipo' => 'Transferencias',
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        if ($request->format == 'pdf') {
            // Generar PDF
            $pdf = Pdf::loadView('reportes.transferencia_pdf', compact('transferencias'));
            return $pdf->download('reporte_transferencias.pdf');
        }

        
    }
}
