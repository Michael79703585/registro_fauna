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
        Schema::table('faunas', function (Blueprint $table) {
            // Asegúrate de que esta línea esté comentada si la columna ya existe
            // $table->unsignedBigInteger('institucion_id')->nullable()->after('user_id');
            
            // Solo agregamos la clave foránea si la columna ya existe
            $table->foreign('institucion_id')->references('id')->on('instituciones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faunas', function (Blueprint $table) {
            $table->dropForeign(['institucion_id']);
            // Solo descomenta si quieres eliminar la columna también
            // $table->dropColumn('institucion_id');
        });
    }
};
