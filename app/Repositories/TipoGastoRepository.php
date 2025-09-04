<?php

namespace App\Repositories;

use App\Models\TipoGasto;

class TipoGastoRepository
{
    public function all()
    {
        return TipoGasto::all();
    }

    public function find($id)
    {
        return TipoGasto::findOrFail($id);
    }

    public function create(array $data)
    {
        return TipoGasto::create($data);
    }

    public function update(TipoGasto $model, array $data)
    {
        $model->update($data);
        return $model;
    }

    public function delete(TipoGasto $model)
    {
        return $model->delete();
    }
}
