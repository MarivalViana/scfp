<?php

namespace Tests\Feature;

use App\Models\TipoGasto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TipoGastoDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_persistencia_no_banco()
    {
        // 1. Create a TipoGasto record using the factory
        // We override the default factory data with our specific test values
        $tipoGasto = TipoGasto::factory()->create([
            'descricao' => 'Fixo',
            'ativo' => true,
        ]);

        // 2. Assert that the record exists in the database
        // We can use the created model instance to check for the correct data
        $this->assertDatabaseHas('tipos_gastos', [
            'id' => $tipoGasto->id, // Use the ID to be more specific
            'descricao' => 'Fixo',
            'ativo' => true,
        ]);

        // 3. (Optional) You can also test the properties of the model instance itself
        $this->assertTrue($tipoGasto->ativo);
        $this->assertEquals('Fixo', $tipoGasto->descricao);
    }
}
