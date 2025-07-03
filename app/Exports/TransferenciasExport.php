<?php

namespace App\Exports;

use App\Models\Transferencia;
use App\Models\Fauna;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransferenciasExport implements FromCollection, WithHeadings
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user ?? Auth::user();
    }

    public function collection()
    {
        // Obtener fauna registrada por el usuario
        $faunaRegistradaIds = Fauna::where('user_id', $this->user->id)->pluck('id');

        // Obtener fauna transferida a su institución
        $faunaTransferidaIds = Transferencia::where('institucion_destino', $this->user->institucion_id)->pluck('fauna_id');

        // Unificar fauna válida para exportar
        $faunaIds = $faunaRegistradaIds->merge($faunaTransferidaIds)->unique();

        return Transferencia::with('fauna', 'institucionOrigen', 'institucionDestino')
            ->whereIn('fauna_id', $faunaIds)
            ->get()
            ->map(function ($t) {
                return [
                    'Código' => $t->fauna->codigo ?? 'N/A',
                    'Tipo Animal' => $t->fauna->tipo_animal ?? 'N/A',
                    'Especie' => $t->fauna->especie ?? 'N/A',
                    'Nombre Común' => $t->fauna->nombre_comun ?? 'N/A',
                    'Institución Origen' => $t->institucionOrigen->nombre ?? 'N/A',
                    'Institución Destino' => $t->institucionDestino->nombre ?? $t->institucion_destino ?? 'N/A',
                    'Fecha Transferencia' => optional($t->fecha_transferencia)->format('d/m/Y'),
                    'Motivo' => $t->motivo ?? 'N/A',
                    'Estado' => ucfirst($t->estado ?? 'N/A'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Código',
            'Tipo Animal',
            'Especie',
            'Nombre Común',
            'Institución Origen',
            'Institución Destino',
            'Fecha Transferencia',
            'Motivo',
            'Estado',
        ];
    }
}
