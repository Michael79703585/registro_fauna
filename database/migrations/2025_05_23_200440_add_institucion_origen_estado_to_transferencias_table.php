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
        $table->string('institucion_origen')->after('fauna_id');
        $table->enum('estado', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente')->after('institucion_destino');
        $table->date('fecha_transferencia')->nullable()->change(); // fecha transfer, ahora nullable
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('transferencias', function (Blueprint $table) {
        $table->dropColumn(['institucion_origen', 'estado']);
    });
}
};
