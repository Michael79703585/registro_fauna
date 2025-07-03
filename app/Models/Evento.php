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
        'codigo',  // ¿Para qué se usa este campo? Podría generar confusión con codigo_animal

        // Campos específicos por tipo de evento
        'especie',
        'nombre_comun',
        'sexo',
        'senas_particulares',
        'codigo_padres',
        'tipo_animal',
        'codigo_animal',  // Este es el que relaciona con fauna->codigo
        'edad',
        'descripcion_fuga',
        'causas_deceso',
        'tratamientos_realizados',
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
