<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Define o relacionamento com a model de Usuário.
     * Este método será herdado por todas as models que estendem BaseModel.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
