<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Impersonate;

    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'direccion',
        'institucion_id',
        'cargo',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relación con institución
    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function faunas()
    {
        return $this->hasMany(\App\Models\Fauna::class);
    }
}
