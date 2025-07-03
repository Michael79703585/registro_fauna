<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReporteIdToFaunasTable extends Migration
{
    public function up()
    {
        Schema::table('faunas', function (Blueprint $table) {
            $table->unsignedBigInteger('reporte_id')->nullable()->after('id'); // O sin nullable si lo necesitas obligatorio
            $table->foreign('reporte_id')->references('id')->on('reportes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('faunas', function (Blueprint $table) {
            $table->dropForeign(['reporte_id']);
            $table->dropColumn('reporte_id');
        });
    }
};
