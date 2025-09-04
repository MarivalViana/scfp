<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModelObserver
{
    public function creating(Model $model)
    {
        // Verifica se a model tem a coluna 'user_id' e se um usuário está autenticado
        if (Auth::check() && $model->isFillable('user_id')) {
            $model->user_id = Auth::id();
        }
    }
}
