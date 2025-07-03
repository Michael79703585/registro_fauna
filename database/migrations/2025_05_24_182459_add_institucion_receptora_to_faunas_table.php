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
    Schema::table('faunas', function (Blueprint $table) {
        $table->string('institucion_receptora')->nullable()->after('institucion_remitente');
    });
}

public function down()
{
    Schema::table('faunas', function (Blueprint $table) {
        $table->dropColumn('institucion_receptora');
    });
}

};
