<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    public function up()
{
    Schema::create('reportes', function (Blueprint $table) {
        $table->id();
        $table->string('tipo');
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->date('fecha_creacion')->nullable(); // Se puede llenar automáticamente
        $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade'); // Relación con tabla instituciones
        $table->string('evento_id'); // Usado como identificador de tipo de evento (registro, historial, etc.)
        $table->timestamps();
    });
}
    public function down()
    {
        Schema::dropIfExists('reportes');
    }
}
