<?php

namespace Tests\Feature;

use App\Models\Gasto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GastoDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_persistencia_no_banco()
    {
        $gasto = Gasto::create([
            'descricao' => 'Compra de cadeira',
            'data' => '2025-08-29',
            'quantidade' => 2,
            'valor' => 700.00,
        ]);

        $this->assertDatabaseHas('gastos', [
            'descricao' => 'Compra de cadeira',
            'quantidade' => 2,
        ]);
    }
}
