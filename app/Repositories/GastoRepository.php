<?php

namespace App\Repositories;

use App\Models\Gasto;

class GastoRepository
{
    public function all()
    {
        return Gasto::all();
    }

    public function find($id)
    {
        return Gasto::findOrFail($id);
    }

    public function create(array $data)
    {
        return Gasto::create($data);
    }

    public function update(Gasto $gasto, array $data)
    {
        $gasto->update($data);
        return $gasto;
    }

    public function delete(Gasto $gasto)
    {
        return $gasto->delete();
    }
}
