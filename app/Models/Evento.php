<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha' => 'date',
    ];

    protected $fillable = [
    'tipo_evento_id',
    'fauna_id',
    'institucion_id',
    'fecha',
    'observaciones',
    'foto',
    'codigo',  // Código del evento (nacimiento, fuga, deceso, etc.)
    'especie',
    'nombre_comun',
    'sexo',
    'senas_particulares',
    'codigo_padres',
    'tipo_animal',
    'codigo_animal',  // Relación con fauna->codigo
    'edad',
    'descripcion_fuga',
    'causas_deceso',
    'tratamientos_realizados',
    'estado_general',  // << Este te faltaba
    'user_id',
];


    public function tipoEvento()
    {
        return $this->belongsTo(TipoEvento::class);
    }

    public function fauna()
    {
        // Relaciona el evento con fauna usando codigo_animal = fauna.codigo
        return $this->belongsTo(Fauna::class, 'codigo_animal', 'codigo');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
