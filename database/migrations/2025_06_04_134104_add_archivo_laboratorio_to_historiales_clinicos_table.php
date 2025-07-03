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
    Schema::table('historiales_clinicos', function (Blueprint $table) {
        $table->string('archivo_laboratorio')->nullable()->after('foto_animal');
    });
}

public function down()
{
    Schema::table('historiales_clinicos', function (Blueprint $table) {
        $table->dropColumn('archivo_laboratorio');
    });
}

};
