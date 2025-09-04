<?php

namespace Tests\Unit;

use App\Models\TipoGasto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TipoGastoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criacao_de_um_gasto()
    {

        $gasto = TipoGasto::create([
            'descricao' => 'Fixo',
            'ativo' => true,
        ]);

        $this->assertDatabaseHas('tipos_gastos', [
            'descricao' => 'Fixo',
            'ativo' => true,
        ]);

    }
}
