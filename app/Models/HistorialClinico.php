<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialClinico extends Model
{
    use HasFactory;

    protected $table = 'historiales_clinicos';

    protected $fillable = [
        'fauna_id',
        'fecha',
        'examen_general',
        'etologia',
        'diagnostico',
        'tratamiento',
        'nutricion',
        'pruebas_laboratorio',
        'recomendaciones',
        'observaciones',
        'foto_animal',
        'archivo_laboratorio',
    ];

    // Cast para transformar examen_general a array automáticamente
    protected $casts = [
        'examen_general' => 'array',
        'fecha' => 'date',
    ];

    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }
}
