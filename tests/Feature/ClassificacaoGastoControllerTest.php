<?php

namespace Tests\Feature;

use App\Models\ClassificacaoGasto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassificacaoGastoControllerTest extends TestCase
{
    protected $user;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    // Teste para a rota index
    public function test_listar()
    {
        // Crie 3 gastos para o usuário de teste
        ClassificacaoGasto::factory(3)->create();

        // Simule a autenticação e acesse a rota
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/classificacao-gasto');

        // Verifique a resposta e a quantidade de itens
        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_criar()
    {
        // 1. O código de criação do usuário e tipoGasto está correto.
        $user = User::factory()->create();

        // 2. Os dados enviados na requisição também estão corretos.
        $dados = [
            'descricao' => 'Fixo',
            'ativo' => true,
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/classificacao-gasto', $dados);

        // 3. Verificações de asserção da resposta JSON estão corretas.
        $response->assertStatus(201)
            ->assertJsonFragment([
                'descricao' => 'Fixo',
                'ativo' => true,
            ]);

        // 4. CORREÇÃO AQUI: Ajuste os dados para a asserção no banco de dados
        $dadosParaBD = [
            'descricao' => 'Fixo',
            'ativo' => 1,
        ];

        $this->assertDatabaseHas('classificacoes_gastos', $dadosParaBD);
    }


    // Testes de validação para a criação
    public function test_nao_deve_criar_com_dados_invalidos()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/classificacao-gasto', [
                'descricao' => '',
                'ativo' => 'texto',
            ]);

        $response->assertStatus(422) // Unprocessable Entity
            ->assertJsonValidationErrors(['descricao', 'ativo']);
    }

    public function test_buscar()
    {
        $gasto = ClassificacaoGasto::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/classificacao-gasto/{$gasto->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $gasto->id,
                'descricao' => $gasto->descricao,
            ]);
    }

    public function test_atualizar()
    {
        $gasto = ClassificacaoGasto::factory()->create();

        $dadosAtualizados = [
            'descricao' => 'Fixo Atualizado',
            'ativo' => true,
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/classificacao-gasto/{$gasto->id}", $dadosAtualizados);

        $response->assertStatus(200)
            ->assertJson(['descricao' => 'Fixo Atualizado']);

        $this->assertDatabaseHas('classificacoes_gastos', [
            'id' => $gasto->id,
            'descricao' => 'Fixo Atualizado'
        ]);
    }

    public function test_deletar()
    {
        $gasto = ClassificacaoGasto::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/classificacao-gasto/{$gasto->id}");

        $response->assertStatus(204); // No Content

        $this->assertDatabaseMissing('classificacoes_gastos', ['id' => $gasto->id]);
    }
}
