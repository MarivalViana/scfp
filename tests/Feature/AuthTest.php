<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    // Use este trait para resetar o banco de dados para cada teste
    use RefreshDatabase;

    /**
     * Teste para verificar se um usuário pode fazer login e obter um token.
     *
     * @return void
     */
    public function test_user_can_login_and_get_a_token()
    {
        // 1. Preparar o ambiente
        // Criar um usuário de teste no banco de dados
        $user = User::factory()->create([
            'email' => 'marivalvmf@gmail.com',
            'password' => Hash::make('dbo@1234'),
        ]);

        $loginData = [
            'email' => 'marivalvmf@gmail.com',
            'password' => 'dbo@1234',
        ];

        // 2. Realizar a ação (enviar a requisição de login)
        $response = $this->postJson('/api/login', $loginData);

        // 3. Fazer as asserções
        // Verificar se a resposta tem o status HTTP 200 (OK)
        $response->assertStatus(200);

        // Verificar se a estrutura da resposta contém o token de acesso
        $response->assertJsonStructure([
            'access_token',
            'token_type'
        ]);

        // Opcional: Verificar se o token de acesso não está vazio
        $this->assertIsString($response->json('access_token'));
        $this->assertNotEmpty($response->json('access_token'));
    }

    /**
     * Teste para verificar se o login falha com credenciais inválidas.
     *
     * @return void
     */
    public function test_login_fails_with_invalid_credentials()
    {
        // 1. Preparar o ambiente
        $user = User::factory()->create([
            'email' => 'marivalvmf@gmail.com',
            'password' => Hash::make('dbo@1234'),
        ]);

        $loginData = [
            'email' => 'teste@exemplo.com',
            'password' => 'senhainvalida',
        ];

        // 2. Realizar a ação
        $response = $this->postJson('/api/login', $loginData);

        // 3. Fazer as asserções
        // Verificar se a resposta tem o status HTTP 401 (Unauthorized)
        $response->assertStatus(401);

        // Verificar se a resposta JSON contém a mensagem de erro esperada
        $response->assertJson(['message' => 'Credenciais inválidas.']);
    }
}
