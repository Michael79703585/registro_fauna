<?php

namespace Database\Factories;

use App\Models\Fauna;
use App\Models\FaunaDocumento;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaunaDocumentoFactory extends Factory
{
    protected $model = FaunaDocumento::class;

    public function definition(): array
    {
        return [
            'fauna_id' => Fauna::factory(),
            'nombre_archivo' => $this->faker->word . '.pdf',
            'ruta_archivo' => 'documentos/fauna/' . $this->faker->uuid . '.pdf',
            'tipo_documento' => $this->faker->randomElement(['Informe Médico', 'Certificado', null]),
            'fecha_subida' => now(),
        ];
    }
}
