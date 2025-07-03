<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tipo_evento_id')->constrained('tipo_eventos')->onDelete('cascade');
            $table->foreignId('fauna_id')->nullable()->constrained('faunas')->nullOnDelete();
            $table->foreignId('institucion_id')->nullable()->constrained('instituciones')->onDelete('set null');

            $table->date('fecha');
            $table->text('observaciones')->nullable();
            $table->string('foto')->nullable();
            $table->string('codigo')->unique();

            // Campos específicos para distintos tipos de evento
            $table->string('especie')->nullable();
            $table->string('nombre_comun')->nullable();
            $table->enum('sexo', ['Macho', 'Hembra', 'Indeterminado'])->nullable();
            $table->string('senas_particulares')->nullable();
            $table->string('codigo_padres')->nullable();
            $table->string('tipo_animal')->nullable();

            $table->string('codigo_animal')->nullable();
            $table->integer('edad')->nullable();
            $table->text('descripcion_fuga')->nullable();

            $table->string('causas_deceso')->nullable();
            $table->text('tratamientos_realizados')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
