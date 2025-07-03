<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
    ];

    public function index()
{
    $publicaciones = []; // arreglo vacío temporal
    return view('welcome', compact('publicaciones'));
}

    public function images()
{
    return $this->hasMany(PublicationImage::class);
}

public function publication()
{
    return $this->belongsTo(Publication::class);
}

protected $casts = [
    'image_path' => 'array', // Para que Laravel lo trate como array automáticamente
];

}