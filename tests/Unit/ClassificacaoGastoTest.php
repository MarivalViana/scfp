<?php

namespace Tests\Unit;

use App\Models\ClassificacaoGasto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassificacaoGastoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criacao_de_um_gasto()
    {

        $gasto = ClassificacaoGasto::create([
            'descricao' => 'Alimentação',
            'ativo' => true,
        ]);

        $this->assertDatabaseHas('classificacoes_gastos', [
            'descricao' => 'Alimentação',
            'ativo' => true,
        ]);

    }
}
