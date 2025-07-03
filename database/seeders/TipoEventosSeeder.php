<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEventosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipo_eventos')->insert([
            ['nombre' => 'Nacimiento'],
            ['nombre' => 'Fuga'],
            ['nombre' => 'Deceso'],
        ]);
    }
}
