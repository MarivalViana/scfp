<?php

namespace App\Http\Controllers;

use App\Services\TipoGastoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoGastoController extends Controller
{
    protected $service;

    public function __construct(TipoGastoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->listarTodos());
    }

    public function store(Request $request)
    {

        $dados = $request->validate([
            'descricao' => 'required|string|max:500',
            'ativo' => 'required|boolean',
        ]);

        try {
            // Pass the updated data array to the service
            $model = $this->service->salvar($dados);
            return response()->json($model, 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $model = $this->service->buscarPorId($id);
            return response()->json($model);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Tipo Gasto não encontrado.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'descricao' => 'required|string|max:500',
            'ativo' => 'required|boolean',
        ]);

        try {
            $model = $this->service->atualizar($id, $dados);
            return response()->json($model);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Tipo Gasto não encontrado.'], 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->deletar($id);
            return response()->json(null, 204); // Status 204 No Content para deleção bem-sucedida
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Tipo Gasto não encontrado.'], 404);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Tipo Gasto Já está em uso.'], 404);
        }
    }
}
