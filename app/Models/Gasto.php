<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gastos'; // tabela no banco

    protected $fillable = [
        'descricao',
        'data',
        'quantidade',
        'valor',
    ];

    // caso queira que 'data' seja tratada como objeto Date
    protected $casts = [
        'data' => 'date',
        'valor' => 'decimal:2',
    ];
}
