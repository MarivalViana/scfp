<?php

namespace Tests\Feature;

use App\Models\ClassificacaoGasto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassificacaoGastoDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_persistencia_no_banco()
    {
        // 1. Create a ClassificacaoGasto record using the factory
        // We override the default factory data with our specific test values
        $ClassificacaoGasto = ClassificacaoGasto::factory()->create([
            'descricao' => 'Fixo',
            'ativo' => true,
        ]);

        // 2. Assert that the record exists in the database
        // We can use the created model instance to check for the correct data
        $this->assertDatabaseHas('classificacoes_gastos', [
            'id' => $ClassificacaoGasto->id, // Use the ID to be more specific
            'descricao' => 'Fixo',
            'ativo' => true,
        ]);

        // 3. (Optional) You can also test the properties of the model instance itself
        $this->assertTrue($ClassificacaoGasto->ativo);
        $this->assertEquals('Fixo', $ClassificacaoGasto->descricao);
    }
}
