<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'institucion_id',
        'evento_id',
        'datos_poblacion',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_recepcion' => 'datetime',
        'fecha_fin' => 'date',
        'datos_poblacion' => 'array',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function faunas()
    {
        return $this->hasMany(Fauna::class);
    }
}
