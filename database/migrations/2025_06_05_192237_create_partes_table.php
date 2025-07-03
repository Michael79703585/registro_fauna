<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartesTable extends Migration
{
    public function up(): void
    {
        Schema::create('partes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable(); // generado automáticamente
            $table->string('animal')->nullable(); // solo si también usarás como genérico
            $table->string('tipo_parte')->nullable();
            $table->integer('cantidad')->nullable();
            $table->date('fecha')->nullable();

            $table->string('tipo_registro')->nullable(); // parte, derivado, animal muerto

            $table->date('fecha_recepcion');
            $table->string('ciudad', 100)->nullable();
            $table->string('departamento', 100)->nullable();
            $table->string('coordenadas', 100)->nullable();
            $table->string('tipo_elemento', 50)->nullable();
            $table->string('motivo_ingreso', 50)->nullable();
            $table->string('lugar', 100)->nullable();
            $table->string('institucion_remitente', 100)->nullable();
            $table->string('nombre_persona_recibe', 100)->nullable();
            $table->string('especie', 100);
            $table->string('nombre_comun', 100)->nullable();
            $table->string('tipo_animal', 50)->nullable();

            $table->string('destino')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('disposicion_final')->nullable();
            $table->string('foto')->nullable(); // puede ser la ruta al archivo

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partes');
    }
}
