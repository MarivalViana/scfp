<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificacaoGasto extends Model
{
    use HasFactory;

    protected $table = 'classificacoes_gastos';

    protected $fillable = ['descricao', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}
