<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoGasto extends Model
{
    use HasFactory; // <-- Add this trait

    protected $table = 'tipos_gastos';

    protected $fillable = ['descricao', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}
