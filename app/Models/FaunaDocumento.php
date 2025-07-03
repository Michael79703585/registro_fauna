<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FaunaDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        'fauna_id',
        'nombre_archivo',
        'ruta_archivo',
        'tipo_documento',
    ];

    /**
     * Relación inversa: un documento pertenece a una fauna.
     */
    public function fauna()
    {
        return $this->belongsTo(Fauna::class);
    }
}
