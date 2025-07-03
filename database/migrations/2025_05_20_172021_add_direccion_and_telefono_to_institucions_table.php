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
    Schema::table('instituciones', function (Blueprint $table) {
        if (!Schema::hasColumn('instituciones', 'direccion')) {
            $table->string('direccion')->nullable();
        }
        if (!Schema::hasColumn('instituciones', 'telefono')) {
            $table->string('telefono')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('instituciones', function (Blueprint $table) {
            $table->dropColumn(['direccion', 'telefono']);
        });
    }
};
