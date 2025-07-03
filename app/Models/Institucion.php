<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institucion extends Model
{
    use HasFactory;

    protected $table = 'instituciones'; // ✅ Esto está correcto

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
    
      public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
