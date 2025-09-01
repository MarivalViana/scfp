<?php

namespace Tests\Feature;

use App\Models\Gasto;
use App\Models\User; // Importe o modelo User
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GastoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_gasto_via_api()
    {
        // 1. Criar um usuário de teste no banco de dados
        $user = User::factory()->create();

        // 2. Simular a autenticação do usuário para esta requisição
        // O segundo argumento 'sanctum' é a guarda de autenticação
        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/gastos', [
                             'descricao' => 'Compra de computador',
                             'data' => '2025-08-29',
                             'quantidade' => 1,
                             'valor' => 3500.00,
                         ]);

        // 3. Fazer as asserções
        $response->assertStatus(201) // Created
                 ->assertJson([
                     'descricao' => 'Compra de computador',
                     'quantidade' => 1,
                 ]);

        $this->assertDatabaseHas('gastos', [
            'descricao' => 'Compra de computador',
        ]);
    }
}
