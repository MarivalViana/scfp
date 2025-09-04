<?php

namespace Database\Factories;

use App\Models\TipoGasto;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoGastoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TipoGasto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descricao' => $this->faker->unique()->word(),
            'ativo' => $this->faker->boolean(),
        ];
    }
}
