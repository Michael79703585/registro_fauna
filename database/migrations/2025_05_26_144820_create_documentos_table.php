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
    Schema::create('documentos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fauna_id')->constrained()->onDelete('cascade');
        $table->string('nombre');
        $table->string('ruta'); // path al archivo
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
