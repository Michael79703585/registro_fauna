<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    public function fauna()
{
    return $this->belongsTo(Fauna::class);
}
}
