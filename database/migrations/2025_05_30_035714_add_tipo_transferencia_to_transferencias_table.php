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
    Schema::table('transferencias', function (Blueprint $table) {
        $table->string('tipo_transferencia')->nullable(); // o enum('transferido', 'recepcion')
    });
}

public function down()
{
    Schema::table('transferencias', function (Blueprint $table) {
        $table->dropColumn('tipo_transferencia');
    });
}

};
