<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiberacionesTable extends Migration
{
    public function up()
    {
        Schema::create('liberaciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->date('fecha');
            $table->string('lugar_liberacion');
            $table->string('departamento');
            $table->string('municipio');
            $table->string('coordenadas')->nullable();
            $table->string('tipo_animal');
            $table->string('especie');
            $table->string('nombre_comun')->nullable();
            $table->string('responsable');
            $table->string('institucion')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('liberaciones');
    }
}
