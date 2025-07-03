<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FaunasExport implements FromCollection, WithHeadings
{
    protected $faunas;

    public function __construct(Collection $faunas)
    {
        $this->faunas = $faunas;
    }

    public function collection()
    {
        // Solo devolvemos las columnas necesarias
        return $this->faunas->map(function ($fauna) {
            return [
                $fauna->codigo,
                $fauna->fecha_recepcion,
                $fauna->ciudad,
                $fauna->departamento,
                $fauna->coordenadas,
                $fauna->tipo_elemento,
                $fauna->motivo_ingreso,
                $fauna->lugar,
                $fauna->institucion_remitente,
                $fauna->nombre_persona_recibe,
                $fauna->especie,
                $fauna->nombre_comun,
                $fauna->tipo_animal,
                $fauna->edad_aparente,
                $fauna->estado_general,
                $fauna->sexo,
                $fauna->comportamiento,
                $fauna->sospecha_enfermedad ? 'SI' : 'NO',
                $fauna->descripcion_enfermedad,
                $fauna->alteraciones_evidentes,
                $fauna->otras_observaciones,
                $fauna->tiempo_cautiverio,
                $fauna->tipo_alojamiento,
                $fauna->contacto_con_animales ? 'SI' : 'NO',
                $fauna->descripcion_contacto,
                $fauna->padecio_enfermedad ? 'SI' : 'NO',
                $fauna->descripcion_padecimiento,
                $fauna->tipo_alimentacion,
                $fauna->derivacion_ccfs ? 'SI' : 'NO',
                $fauna->descripcion_derivacion,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Código', 'Fecha Recepción', 'Ciudad', 'Departamento', 'Coordenadas', 'Tipo Elemento',
            'Motivo Ingreso', 'Lugar', 'Institución Remitente', 'Nombre Persona Recibe',
            'Especie', 'Nombre Común', 'Tipo Animal', 'Edad Aparente', 'Estado General', 'Sexo',
            'Comportamiento', 'Sospecha Enfermedad', 'Descripción Enfermedad', 'Alteraciones Evidentes',
            'Otras Observaciones', 'Tiempo Cautiverio', 'Tipo Alojamiento', 'Contacto con Animales',
            'Descripción Contacto', 'Padeció Enfermedad', 'Descripción Padecimiento', 'Tipo Alimentación',
            'Derivación CCFS', 'Descripción Derivación'
        ];
    }
}
