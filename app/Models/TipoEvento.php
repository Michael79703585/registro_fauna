<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
