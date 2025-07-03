<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Parte extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'animal',
        'tipo_parte',
        'cantidad',
        'fecha',
        'tipo_registro',
        'fecha_recepcion',
        'ciudad',
        'departamento',
        'coordenadas',
        'tipo_elemento',
        'motivo_ingreso',
        'lugar',
        'institucion_remitente',
        'nombre_persona_recibe',
        'especie',
        'nombre_comun',
        'tipo_animal',
        'destino',
        'observaciones',
        'disposicion_final',
        'foto',
    ];

    // <-- ✅ Solución: asegurar que los campos se traten como fechas
    protected $casts = [
        'fecha' => 'datetime',
        'fecha_recepcion' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($parte) {
            if (empty($parte->codigo) && !empty($parte->institucion_remitente)) {
                $parte->codigo = self::generarCodigo($parte->institucion_remitente);
            }
        });
    }

  public function getFotoUrlAttribute()
{
    return $this->foto ? asset('storage/' . $this->foto) : null;
}


    protected static function generarCodigo($institucion)
    {
        $prefijo = strtoupper(Str::slug($institucion));
        $numero = self::where('institucion_remitente', $institucion)->count() + 1;
        return $prefijo . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

}
