<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transferencia extends Model
{
    use HasFactory;

    protected $fillable = [
    'fauna_id',
    'institucion_origen',
    'institucion_destino',
    'fecha_transferencia',
    'motivo',
    'observaciones',
    'estado',
];

    public function fauna()
    {
        return $this->belongsTo(\App\Models\Fauna::class, 'fauna_id');
    }
public function institucionDestino()
{
     return $this->belongsTo(Institucion::class, 'institucion_destino');
}

public function institucionOrigen()
{
    return $this->belongsTo(Institucion::class, 'institucion_origen');
}

public function getFechaTransferenciaFormateadaAttribute()
{
    return $this->fecha_transferencia
        ? \Carbon\Carbon::parse($this->fecha_transferencia)->format('d/m/Y')
        : null;
}

}
