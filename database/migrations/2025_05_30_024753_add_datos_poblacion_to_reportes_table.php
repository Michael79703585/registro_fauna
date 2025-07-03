<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatosPoblacionToReportesTable extends Migration
{
    public function up()
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->json('datos_poblacion')->nullable()->after('evento_id');
        });
    }

    public function down()
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropColumn('datos_poblacion');
        });
    }
}
