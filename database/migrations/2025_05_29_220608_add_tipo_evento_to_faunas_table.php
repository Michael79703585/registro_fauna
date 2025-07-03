<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoEventoToFaunasTable extends Migration
{
    public function up()
    {
        Schema::table('faunas', function (Blueprint $table) {
            $table->string('tipo_evento')->nullable()->after('reporte_id');
        });
    }

    public function down()
    {
        Schema::table('faunas', function (Blueprint $table) {
            $table->dropColumn('tipo_evento');
        });
    }
};
