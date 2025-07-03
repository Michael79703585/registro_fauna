<?php

namespace Database\Factories;

use App\Models\Fauna;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaunaFactory extends Factory
{
    protected $model = Fauna::class;

    public function definition(): array
    {
        return [
            'nombre_comun' => $this->faker->word,
            'nombre_cientifico' => $this->faker->words(2, true),
            // Agrega aquí otros campos requeridos según tu modelo real
        ];
    }
}
