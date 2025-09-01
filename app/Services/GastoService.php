<?php

namespace App\Services;

use App\Repositories\GastoRepository;

class GastoService
{
    protected $repository;

    public function __construct(GastoRepository $repository)
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
        if ($dados['valor'] < 0) {
            throw new \InvalidArgumentException("O valor não pode ser negativo");
        }
        return $this->repository->create($dados);
    }

    public function atualizar($id, array $dados)
    {
        // Regra de negócio: garantir que valor não seja negativo na atualização também
        if (isset($dados['valor']) && $dados['valor'] < 0) {
            throw new \InvalidArgumentException("O valor não pode ser negativo");
        }

        $gasto = $this->repository->find($id);
        return $this->repository->update($gasto, $dados);
    }

    public function deletar($id)
    {
        $gasto = $this->repository->find($id);
        return $this->repository->delete($gasto);
    }
}
