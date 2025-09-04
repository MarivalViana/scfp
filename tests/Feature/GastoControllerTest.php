<?php

namespace Tests\Feature;

use App\Models\Gasto;
use App\Models\User;
use App\Models\TipoGasto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GastoControllerTest extends TestCase
{
    use RefreshDatabase;

    // Declare the properties here
    protected $user;
    protected $tipoGasto;

    // Ações que devem ser executadas antes de cada teste
    protected function setUp(): void
    {
        parent::setUp();
        // Crie um usuário de teste e o tipo de gasto para usar em todos os testes
        $this->user = User::factory()->create();
        $this->tipoGasto = TipoGasto::factory()->create();
    }

    // Teste para a rota index
    public function test_listar_gastos_do_usuario()
    {
        // Crie 3 gastos para o usuário de teste
        Gasto::factory(3)->create(['user_id' => $this->user->id]);

        // Simule a autenticação e acesse a rota
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/gasto');

        // Verifique a resposta e a quantidade de itens
        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_criar_gasto_via_api()
    {
        // 1. O código de criação do usuário e tipoGasto está correto.
        $user = User::factory()->create();
        $tipoGasto = TipoGasto::factory()->create();

        // 2. Os dados enviados na requisição também estão corretos.
        $dadosGasto = [
            'descricao' => 'Compra de computador',
            'data' => '2025-08-29',
            'quantidade' => 1,
            'valor' => 3500.00,
            'compartilhado' => false,
            'repeticao' => false,
            'valor_dividido' => false,
            'anual' => false,
            'tipo_gasto_id' => $tipoGasto->id,
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/gasto', $dadosGasto);

        // 3. Verificações de asserção da resposta JSON estão corretas.
        $response->assertStatus(201)
            ->assertJsonFragment([
                'descricao' => 'Compra de computador',
                'quantidade' => 1,
                'valor' => '3500.00',
                'tipo_gasto_id' => $tipoGasto->id,
                'user_id' => $user->id,
            ]);

        // 4. CORREÇÃO AQUI: Ajuste os dados para a asserção no banco de dados
        $dadosParaBD = [
            'descricao' => 'Compra de computador',
            'data' => '2025-08-29 00:00:00', // Formato de data do banco
            'quantidade' => 1,
            'valor' => 3500, // Valor é armazenado como float ou decimal, o PHPUnit converte
            'compartilhado' => 0, // Booleanos são salvos como 0 ou 1
            'repeticao' => 0,
            'valor_dividido' => 0,
            'anual' => 0,
            'tipo_gasto_id' => $tipoGasto->id,
            'user_id' => $user->id,
        ];

        $this->assertDatabaseHas('gastos', $dadosParaBD);
    }


    // Testes de validação para a criação
    public function test_nao_deve_criar_gasto_com_dados_invalidos()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/gasto', [
                'descricao' => '', // Campo obrigatório
                'valor' => 'texto', // Tipo de dado inválido
            ]);

        $response->assertStatus(422) // Unprocessable Entity
            ->assertJsonValidationErrors(['descricao', 'valor']);
    }

    public function test_buscar_gasto_proprio()
    {
        $gasto = Gasto::factory()->create([
            'user_id' => $this->user->id,
            'tipo_gasto_id' => $this->tipoGasto->id,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/gasto/{$gasto->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $gasto->id,
                'descricao' => $gasto->descricao,
            ]);
    }

    public function test_atualizar_gasto_proprio()
    {
        $gasto = Gasto::factory()->create([
            'user_id' => $this->user->id,
            'tipo_gasto_id' => $this->tipoGasto->id,
        ]);

        $dadosAtualizados = [
            'descricao' => 'Gasto Atualizado',
            'valor' => 500.00,
            'data' => '2025-09-01',
            'quantidade' => 1,
            'compartilhado' => true,
            'repeticao' => false,
            'valor_dividido' => true,
            'anual' => false,
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/gasto/{$gasto->id}", $dadosAtualizados);

        $response->assertStatus(200)
            ->assertJson(['descricao' => 'Gasto Atualizado']);

        $this->assertDatabaseHas('gastos', [
            'id' => $gasto->id,
            'descricao' => 'Gasto Atualizado',
            'valor' => 500.00,
        ]);
    }

    public function test_deletar_gasto_proprio()
    {
        $gasto = Gasto::factory()->create([
            'user_id' => $this->user->id,
            'tipo_gasto_id' => $this->tipoGasto->id,
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/gasto/{$gasto->id}");

        $response->assertStatus(204); // No Content

        $this->assertDatabaseMissing('gastos', ['id' => $gasto->id]);
    }
}
