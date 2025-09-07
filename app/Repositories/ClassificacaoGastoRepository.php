<?php

namespace App\Repositories;

use App\Models\ClassificacaoGasto;

class ClassificacaoGastoRepository
{
    public function all()
    {
        return ClassificacaoGasto::all();
    }

    public function find($id)
    {
        return ClassificacaoGasto::findOrFail($id);
    }

    public function create(array $data)
    {
        return ClassificacaoGasto::create($data);
    }

    public function update(ClassificacaoGasto $model, array $data)
    {
        $model->update($data);
        return $model;
    }

    public function delete(ClassificacaoGasto $model)
    {
        return $model->delete();
    }
}
