<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    if (!Schema::hasTable('fauna_documentos')) {
        Schema::create('fauna_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fauna_id')->constrained('faunas')->onDelete('cascade');
            $table->string('nombre_archivo');
            $table->string('ruta_archivo');
            $table->string('tipo_documento')->nullable();
            $table->timestamp('fecha_subida')->useCurrent();
            $table->timestamps();
        });
    }
}
    public function down(): void
    {
        Schema::dropIfExists('fauna_documentos');
    }
};
