<?php

namespace Tests\Unit;

use App\Models\Gasto;
use Tests\TestCase;

class GastoTest extends TestCase
{
    public function test_criacao_de_um_gasto()
    {
        $gasto = new Gasto([
            'descricao' => 'Compra de material de escritório',
            'data' => '2025-08-29',
            'quantidade' => 10,
            'valor' => 120.50,
        ]);

        $this->assertEquals('Compra de material de escritório', $gasto->descricao);
        $this->assertEquals(10, $gasto->quantidade);
        $this->assertEquals(120.50, $gasto->valor);
    }
}
