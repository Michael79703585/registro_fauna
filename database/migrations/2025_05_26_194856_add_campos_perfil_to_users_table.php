<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'telefono') ||
            !Schema::hasColumn('users', 'direccion') ||
            !Schema::hasColumn('users', 'institucion_id') ||
            Schema::hasColumn('users', 'institucion')) {

            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'telefono')) {
                    $table->string('telefono')->nullable()->after('password');
                }

                if (!Schema::hasColumn('users', 'direccion')) {
                    $table->string('direccion')->nullable()->after('telefono');
                }

                if (!Schema::hasColumn('users', 'institucion_id')) {
                    $table->foreignId('institucion_id')->nullable()->constrained('instituciones')->nullOnDelete()->after('direccion');
                }

                if (Schema::hasColumn('users', 'institucion')) {
                    $table->dropColumn('institucion');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'institucion_id')) {
                $table->dropForeign(['institucion_id']);
                $table->dropColumn('institucion_id');
            }

            if (Schema::hasColumn('users', 'telefono')) {
                $table->dropColumn('telefono');
            }

            if (Schema::hasColumn('users', 'direccion')) {
                $table->dropColumn('direccion');
            }

            if (!Schema::hasColumn('users', 'institucion')) {
                $table->string('institucion')->nullable();
            }
        });
    }
};
