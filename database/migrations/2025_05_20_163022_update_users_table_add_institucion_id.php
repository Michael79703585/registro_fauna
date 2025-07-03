<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Primero, eliminar la foreign key si existe
        try {
            DB::statement('ALTER TABLE users DROP FOREIGN KEY users_institucion_id_foreign');
        } catch (\Throwable $e) {
            // Ignorar si no existe
        }

        // Luego agregar o modificar la columna institucion_id para que sea nullable
        Schema::table('users', function (Blueprint $table) {
            // Eliminar columna antigua si existe
            if (Schema::hasColumn('users', 'institucion')) {
                $table->dropColumn('institucion');
            }

            // Agregar la columna si no existe
            if (!Schema::hasColumn('users', 'institucion_id')) {
                $table->unsignedBigInteger('institucion_id')->nullable()->after('id');
            } else {
                // Si existe pero no es nullable, hacer nullable (requerirá extensión doctrine/dbal)
                $table->unsignedBigInteger('institucion_id')->nullable()->change();
            }
        });

        // Finalmente agregar la foreign key (separado para evitar errores)
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('institucion_id')
                ->references('id')
                ->on('instituciones')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['institucion_id']);
            $table->dropColumn('institucion_id');
        });
    }
};
