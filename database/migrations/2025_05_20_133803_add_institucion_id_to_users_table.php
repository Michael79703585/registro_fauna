<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Asegúrate de que esta línea esté presente
        $table->unsignedBigInteger('institucion_id')->nullable()->after('id');

        // Y esta para la foreign key
        $table->foreign('institucion_id')
              ->references('id')
              ->on('instituciones')
              ->onDelete('set null');
    });
}


    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['institucion_id']);
        $table->dropColumn('institucion_id');
    });
}
};
