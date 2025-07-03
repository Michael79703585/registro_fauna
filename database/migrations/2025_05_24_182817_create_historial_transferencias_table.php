<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('historial_transferencias', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('fauna_id');
        $table->unsignedBigInteger('transferencia_id');
        $table->string('institucion_origen');
        $table->string('institucion_destino');
        $table->date('fecha_transferencia');
        $table->string('motivo')->nullable();
        $table->text('observaciones')->nullable();
        $table->timestamps();

        $table->foreign('fauna_id')->references('id')->on('faunas')->onDelete('cascade');
        $table->foreign('transferencia_id')->references('id')->on('transferencias')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_transferencias');
    }
};
