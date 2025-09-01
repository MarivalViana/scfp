<?php

namespace Tests\Feature;

use App\Models\Gasto;
use App\Models\User; // Importe a model User
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GastoDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_persistencia_no_banco()
    {
        // 1. Crie um usuário para satisfazer a chave estrangeira
        $user = User::factory()->create();

        // 2. Crie o gasto associando-o ao usuário que acabou de ser criado
        $gasto = Gasto::create([
            'descricao' => 'Compra de cadeira',
            'data' => '2025-08-29',
            'quantidade' => 2,
            'valor' => 700.00,
            'user_id' => $user->id, // Adicione o user_id aqui
        ]);

        // 3. Verifique se os dados estão no banco
        $this->assertDatabaseHas('gastos', [
            'descricao' => 'Compra de cadeira',
            'quantidade' => 2,
            'user_id' => $user->id, // É bom incluir o user_id na asserção também
        ]);
    }
}
