<?php

namespace App\Exports;

use App\Models\Parte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PartesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

   public function collection()
{
    $query = Parte::query();

    if (!empty($this->filtros['institucion'])) {
        $institucion = strtolower($this->filtros['institucion']);
        $query->whereRaw('LOWER(institucion_remitente) = ?', [$institucion]);
    } else {
        // Si no hay institución definida, no devolver nada
        $query->whereRaw('1 = 0');
    }

    if (!empty($this->filtros['codigo'])) {
        $query->where('codigo', 'like', '%' . $this->filtros['codigo'] . '%');
    }
    if (!empty($this->filtros['fecha_inicio'])) {
        $query->whereDate('fecha_recepcion', '>=', $this->filtros['fecha_inicio']);
    }
    if (!empty($this->filtros['fecha_fin'])) {
        $query->whereDate('fecha_recepcion', '<=', $this->filtros['fecha_fin']);
    }

    return $query->orderBy('fecha_recepcion', 'desc')->get();
}

    public function headings(): array
    {
        return [
            'Código',
            'Tipo Registro',
            'Fecha Recepción',
            'Ciudad',
            'Departamento',
            'Coordenadas',
            'Tipo Elemento',
            'Motivo Ingreso',
            'Institución Remitente',
            'Persona que Recibe',
            'Especie',
            'Nombre Común',
            'Tipo Animal',
            'Cantidad',
            'Fecha',
            'Disposición Final',
            'Observaciones',
            'Foto (Nombre archivo)',
        ];
    }

    public function map($parte): array
    {
        return [
            $parte->codigo,
            ucfirst(str_replace('_', ' ', $parte->tipo_registro)),
            $parte->fecha_recepcion ? $parte->fecha_recepcion->format('d/m/Y') : '',
            $parte->ciudad,
            $parte->departamento,
            $parte->coordenadas,
            $parte->tipo_elemento,
            $parte->motivo_ingreso,
            $parte->institucion_remitente,
            $parte->nombre_persona_recibe,
            $parte->especie,
            $parte->nombre_comun,
            $parte->tipo_animal,
            $parte->cantidad,
            $parte->fecha ? $parte->fecha->format('d/m/Y') : '',
            $parte->disposicion_final,
            $parte->observaciones,
            $parte->foto ?: 'N/A',
        ];
    }
}
