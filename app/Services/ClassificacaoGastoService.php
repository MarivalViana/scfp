<?php

namespace App\Services;

use App\Repositories\ClassificacaoGastoRepository;

class ClassificacaoGastoService
{
    protected $repository;

    public function __construct(ClassificacaoGastoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listarTodos()
    {
        return $this->repository->all();
    }

    public function buscarPorId($id)
    {
        return $this->repository->find($id);
    }

    public function salvar(array $dados)
    {
        return $this->repository->create($dados);
    }

    public function atualizar($id, array $dados)
    {
        $model = $this->repository->find($id);
        return $this->repository->update($model, $dados);
    }

    public function deletar($id)
    {
        $model = $this->repository->find($id);
        return $this->repository->delete($model);
    }
}
