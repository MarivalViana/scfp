<?php

namespace Tests\Unit;

use App\Models\Gasto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GastoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criacao_de_um_gasto()
    {
        // 1. Crie um usuário usando a factory para que o ID exista
        $user = User::factory()->create();

        // 2. Crie um Gasto associado ao usuário
        $gasto = Gasto::create([
            'descricao' => 'Compra de material de escritório',
            'data' => '2025-08-29',
            'quantidade' => 10,
            'valor' => 120.50,
            'user_id' => $user->id, // Atribua o user_id aqui
        ]);

        // 3. Verifique se o gasto foi salvo corretamente no banco de dados
        $this->assertDatabaseHas('gastos', [
            'descricao' => 'Compra de material de escritório',
            'quantidade' => 10,
            'valor' => 120.50,
            'user_id' => $user->id,
        ]);

        // 4. Teste o relacionamento para ter certeza que está correto
        $this->assertEquals($user->id, $gasto->user->id);
    }
}
