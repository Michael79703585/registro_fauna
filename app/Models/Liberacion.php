<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liberacion extends Model
{
    use HasFactory;

    protected $table = 'liberaciones';

    protected $fillable = [
        'codigo',
        'fecha',
        'lugar_liberacion',
        'departamento',
        'municipio',
        'coordenadas',
        'tipo_animal',
        'especie',
        'nombre_comun',
        'responsable',
        'institucion',
        'observaciones',
        'foto',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fauna()
{
    return $this->belongsTo(\App\Models\Fauna::class, 'fauna_id');
}
}
