<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransferFieldsToFaunasTable extends Migration
{
    public function up()
    {
        Schema::table('faunas', function (Blueprint $table) {
            $table->string('institucion_destino')->nullable()->after('institucion_remitente');
            $table->boolean('transferido')->default(false)->after('institucion_destino');
        });
    }

    public function down()
    {
        Schema::table('faunas', function (Blueprint $table) {
            $table->dropColumn(['institucion_destino', 'transferido']);
        });
    }
}
