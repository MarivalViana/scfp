<?php
namespace Database\Factories;

use App\Models\Gasto;
use Illuminate\Database\Eloquent\Factories\Factory;


class GastoFactory extends Factory
{
    protected $model = Gasto::class;

    public function definition()
    {
        // Certifique-se de que os campos aqui correspondem aos seus
        return [
            'descricao' => $this->faker->sentence(),
            'data' => $this->faker->date(),
            'quantidade' => $this->faker->numberBetween(1, 10),
            'valor' => $this->faker->randomFloat(2, 10, 500),
            'user_id' => \App\Models\User::factory(), // Relacionamento com o usuário
            'tipo_gasto_id' => \App\Models\TipoGasto::factory(), // Novo relacionamento
            'classificacao_gasto_id' => \App\Models\ClassificacaoGasto::factory(), // Novo relacionamento
            'compartilhado' => $this->faker->boolean(),
            'repeticao' => $this->faker->boolean(),
            'valor_dividido' => $this->faker->boolean(),
            'anual' => $this->faker->boolean(),
        ];
    }
}
