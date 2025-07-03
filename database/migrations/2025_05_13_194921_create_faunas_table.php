<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faunas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('codigo')->unique();

            $table->string('especie');
            $table->string('nombre_comun')->nullable();
            $table->string('nombre_cientifico')->nullable();

            $table->string('sexo');
            $table->string('edad_aparente')->nullable();
            $table->string('tipo_animal')->nullable();

            // Procedencia y ubicación
            $table->string('procedencia')->nullable(); // puedes eliminar si usas ciudad/departamento/lugar
            $table->string('ciudad')->nullable();
            $table->string('departamento')->nullable();
            $table->string('coordenadas')->nullable();
            $table->string('lugar')->nullable();

            $table->date('fecha_ingreso');
            $table->date('fecha_recepcion')->nullable();

            $table->string('tipo_elemento')->nullable();
            $table->string('motivo_ingreso', 50)->nullable()->change();
            $table->string('estado_general');
            $table->string('estado_ingreso')->nullable();
            $table->string('condicion_fisica')->nullable();
            $table->decimal('peso', 8, 2)->nullable();

            // Institución/persona
            $table->string('institucion_remitente')->nullable();
            $table->string('nombre_persona_recibe')->nullable();

            $table->string('comportamiento')->nullable();

            // Sospecha de enfermedad
            $table->boolean('sospecha_enfermedad')->default(false);
            $table->text('descripcion_enfermedad')->nullable();

            $table->text('alteraciones_evidentes')->nullable();
            $table->text('otras_observaciones')->nullable();

            // Cautiverio y alojamiento
            $table->string('tiempo_cautiverio')->nullable();
            $table->string('tipo_alojamiento')->nullable();

            // Contacto con animales
            $table->boolean('contacto_con_animales')->default(false);
            $table->text('descripcion_contacto')->nullable();

            // Enfermedad previa
            $table->boolean('padecio_enfermedad')->default(false);
            $table->text('descripcion_padecimiento')->nullable();

            $table->text('tipo_alimentacion')->nullable();

            // Derivación
            $table->boolean('derivacion_ccfs')->default(false);
            $table->text('descripcion_derivacion')->nullable();

            $table->text('observaciones')->nullable();

            $table->string('foto')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('faunas');
        Schema::enableForeignKeyConstraints();
    }
};
