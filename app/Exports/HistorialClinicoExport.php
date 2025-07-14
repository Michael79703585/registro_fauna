<?php

namespace App\Exports;

use App\Models\HistorialClinico;
use App\Models\Fauna;
use App\Models\Transferencia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistorialClinicoExport implements FromCollection, WithHeadings
{
    protected $buscar;
    protected $user;

    public function __construct($buscar = null, $user = null)
    {
        $this->buscar = $buscar;
        $this->user = $user;
    }

    public function collection(): Collection
    {
        // Obtener fauna perteneciente a la institucion del usuario (todos los usuarios de esa institucion)
        $faunaRegistrada = Fauna::whereHas('user', function ($query) {
            $query->where('institucion_id', $this->user->institucion_id);
        })->pluck('id');

        // Obtener fauna transferida a la institucion del usuario
        $faunaTransferida = Transferencia::where('institucion_destino', $this->user->institucion_id)
                                         ->pluck('fauna_id');

        // Unificar IDs de fauna autorizada (registrada o transferida)
        $faunaAutorizadaIds = $faunaRegistrada->merge($faunaTransferida)->unique();

        $query = HistorialClinico::with('fauna')
            ->whereIn('fauna_id', $faunaAutorizadaIds)
            ->when($this->buscar, function ($query) {
                $query->whereHas('fauna', function ($q) {
                    $q->where('codigo', 'like', "%{$this->buscar}%")
                      ->orWhere('nombre_comun', 'like', "%{$this->buscar}%");
                });
            })
            ->orderByDesc('fecha')
            ->get();

        return $query->map(function ($historial) {
            return [
                'Código Animal' => $historial->fauna->codigo ?? '',
                'Nombre Común' => $historial->fauna->nombre_comun ?? '',
                'Fecha' => $historial->fecha,
                'Diagnóstico' => $historial->diagnostico,
            ];
        });
    }

    public function headings(): array
    {
        return ['Código Animal', 'Nombre Común', 'Fecha', 'Diagnóstico'];
    }
}
