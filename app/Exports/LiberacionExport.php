<?php

namespace App\Exports;

use App\Models\Liberacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LiberacionExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Liberacion::query();

        // Filtro por usuario logueado si está presente
        if (!empty($this->filters['user_id'])) {
            $query->where('user_id', $this->filters['user_id']);
        }

        // Otros filtros
        if (!empty($this->filters['codigo'])) {
            $query->where('codigo', 'like', '%' . $this->filters['codigo'] . '%');
        }

        if (!empty($this->filters['fecha_inicio'])) {
            $query->whereDate('fecha', '>=', $this->filters['fecha_inicio']);
        }

        if (!empty($this->filters['fecha_fin'])) {
            $query->whereDate('fecha', '<=', $this->filters['fecha_fin']);
        }

        // Selección de columnas
        return $query->get([
            'codigo',
            'fecha',
            'departamento',
            'municipio',
            'tipo_animal',
            'especie',
            'nombre_comun',
            'responsable',
            'coordenadas',
        ]);
    }

    public function headings(): array
    {
        return [
            'Código',
            'Fecha',
            'Departamento',
            'Municipio',
            'Tipo Animal',
            'Especie',
            'Nombre Común',
            'Responsable',
            'Coordenadas',
        ];
    }
}
