<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up()
{
     Schema::create('instituciones', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('direccion')->nullable();
        $table->string('telefono')->nullable();
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('instituciones');
    }
};
