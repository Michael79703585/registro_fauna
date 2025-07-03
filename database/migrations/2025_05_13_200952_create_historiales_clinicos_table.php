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
   Schema::create('historiales_clinicos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('fauna_id')->constrained('faunas')->onDelete('cascade');
    $table->date('fecha');
    $table->json('examen_general')->nullable(); // ✅ aquí el fix
    $table->text('etologia')->nullable();
    $table->text('diagnostico');
    $table->text('tratamiento')->nullable();
    $table->text('nutricion')->nullable();
    $table->text('pruebas_laboratorio')->nullable();
    $table->text('recomendaciones')->nullable();
    $table->text('observaciones')->nullable();
    $table->string('foto_animal')->nullable();
    $table->timestamps();
});
}

  public function down()
{
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('historiales_clinicos');
    Schema::enableForeignKeyConstraints();
}

};
