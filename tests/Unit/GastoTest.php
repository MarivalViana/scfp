<?php

namespace Tests\Unit;

use App\Models\Gasto;
use App\Models\User;
use App\Models\TipoGasto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GastoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criacao_de_um_gasto()
    {
        // 1. Crie um usuário e um tipo de gasto usando as factories
        $user = User::factory()->create();
        $tipoGasto = TipoGasto::factory()->create([ // Use a factory aqui
            'descricao' => 'Alimentação',
            'ativo' => true,
        ]);

        // 2. Crie um Gasto associado ao usuário e ao tipo de gasto
        $gasto = Gasto::create([
            'descricao' => 'Compra de material de escritório',
            'data' => '2025-08-29',
            'quantidade' => 10,
            'valor' => 120.50,
            'user_id' => $user->id,
            'tipo_gasto_id' => $tipoGasto->id,
        ]);

        // 3. Verifique se os dados foram salvos corretamente
        $this->assertDatabaseHas('gastos', [
            'descricao' => 'Compra de material de escritório',
            'quantidade' => 10,
            'valor' => 120.50,
            'user_id' => $user->id,
            'tipo_gasto_id' => $tipoGasto->id, // É bom incluir esta asserção
        ]);

        // 4. Teste os relacionamentos
        $this->assertEquals($user->id, $gasto->user->id);
        $this->assertEquals($tipoGasto->id, $gasto->tipoGasto->id); // Adicione o teste para a nova relação
    }
}
