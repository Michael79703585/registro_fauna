<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fauna_id');
            $table->date('fecha_transferencia');
            $table->string('institucion_destino');
            $table->string('motivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
    
            $table->foreign('fauna_id')->references('id')->on('faunas')->onDelete('cascade');
        });
    }
    public function down()
{
    Schema::table('transferencias', function (Blueprint $table) {
        $table->dropForeign(['fauna_id']); // <-- Este es el nombre de la columna que referencia a 'faunas'
        $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente');
    });

    Schema::dropIfExists('transferencias');
}


};
