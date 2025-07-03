<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transferencias', function (Blueprint $table) {
    // Para evitar el uso de enum que no funciona en SQLite, cambia a string
    $table->string('estado')->default('pendiente')->change();
});
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('transferencias', function (Blueprint $table) {
        DB::statement("ALTER TABLE transferencias MODIFY estado VARCHAR(255)");
    });
}
};
