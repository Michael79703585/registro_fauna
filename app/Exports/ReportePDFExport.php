<?php

namespace App\Exports;

use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportePDFExport implements FromCollection
{
    /**
     * Obtener los datos de la base de datos para exportar.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Aquí puedes ajustar qué datos quieres exportar
        return Reporte::all(['tipo', 'fecha_inicio', 'fecha_fin']);
    }

    /**
     * Exportar los datos como un archivo PDF.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportToPdf()
    {
        $reportes = $this->collection();
    $pdf = Pdf::loadView('reportes.pdf', compact('reportes'));
    return $pdf->download('reportes.pdf');
    }
}
