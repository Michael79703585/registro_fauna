<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fauna_documentos', function (Blueprint $table) {
            $table->id();

            // Relación con fauna
            $table->foreignId('fauna_id')->constrained()->onDelete('cascade');

            // Información del documento
            $table->string('nombre_archivo');
            $table->string('ruta_archivo');
            $table->string('tipo_documento')->nullable(); // Ej: "certificado", "informe", etc.
            $table->timestamp('fecha_subida')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fauna_documentos');
    }
};
