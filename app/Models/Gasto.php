<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gasto extends Model
{
    use HasFactory; // Add this line

    protected $table = 'gastos';

    protected $fillable = [
        'descricao',
        'data',
        'quantidade',
        'valor',
        'user_id',
        'compartilhado',
        'repeticao',
        'valor_dividido',
        'anual',
        'tipo_gasto_id',
    ];

    protected $casts = [
        'data' => 'date',
        'valor' => 'decimal:2',
        'compartilhado' => 'boolean',
        'repeticao' => 'boolean',
        'valor_dividido' => 'boolean',
        'anual' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tipoGasto(): BelongsTo
    {
        return $this->belongsTo(TipoGasto::class, 'tipo_gasto_id');
    }

}
