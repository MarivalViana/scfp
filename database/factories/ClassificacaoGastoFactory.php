<?php

namespace Database\Factories;

use App\Models\ClassificacaoGasto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassificacaoGastoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassificacaoGasto::class;

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
