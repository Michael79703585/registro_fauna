<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialTransferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'fauna_id',
        'transferencia_id',
        'institucion_origen',
        'institucion_destino',
        'fecha_transferencia',
        'motivo',
        'observaciones',
    ];

    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }

    public function transferencia()
    {
        return $this->belongsTo(Transferencia::class);
    }
}
