<?php

namespace Tests\Feature;

use App\Models\Gasto;
use App\Models\User;
use App\Models\TipoGasto; // Adicione esta importação
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GastoDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_persistencia_no_banco()
    {
        // 1. Crie um usuário e um tipo de gasto para satisfazer a chave estrangeira
        $user = User::factory()->create();
        $tipoGasto = TipoGasto::factory()->create(); // Cria o tipo de gasto

        // 2. Crie o gasto associando-o ao usuário e ao tipo de gasto
        $gasto = Gasto::create([
            'descricao' => 'Compra de cadeira',
            'data' => '2025-08-29',
            'quantidade' => 2,
            'valor' => 700.00,
            'user_id' => $user->id,
            'compartilhado' => false,
            'valor_dividido' => false,
            'anual' => false,
            'repeticao' => false,
            'tipo_gasto_id' => $tipoGasto->id, // Adicione o novo campo
        ]);

        // 3. Verifique se os dados estão no banco
        $this->assertDatabaseHas('gastos', [
            'descricao' => 'Compra de cadeira',
            'quantidade' => 2,
            'user_id' => $user->id,
            'compartilhado' => false,
            'valor_dividido' => false,
            'anual' => false,
            'repeticao' => false,
            'tipo_gasto_id' => $tipoGasto->id, // Verifique se o ID foi salvo
        ]);
    }
}
