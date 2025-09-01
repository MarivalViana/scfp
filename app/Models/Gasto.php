<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gasto extends Model
{
    protected $table = 'gastos'; // tabela no banco

    protected $fillable = [
        'descricao',
        'data',
        'quantidade',
        'valor',
        'user_id',
    ];

    // caso queira que 'data' seja tratada como objeto Date
    protected $casts = [
        'data' => 'date',
        'valor' => 'decimal:2',
    ];

    /**
     * Um gasto pertence a um usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
