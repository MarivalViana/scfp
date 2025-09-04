<?php

namespace App\Http\Controllers;

use App\Services\GastoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GastoController extends Controller
{
    protected $service;

    public function __construct(GastoService $service)
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
            'data' => 'required|date',
            'quantidade' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
            'compartilhado' => 'required|boolean',
            'repeticao' => 'required|boolean',
            'valor_dividido' => 'required|boolean',
            'anual' => 'required|boolean',
        ]);

        // // Get the authenticated user's ID
        // $userId = Auth::id();

        // // Add the user_id to the validated data
        // $dados['user_id'] = $userId;

        try {
            // Pass the updated data array to the service
            $gasto = $this->service->salvar($dados);
            return response()->json($gasto, 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $gasto = $this->service->buscarPorId($id);
            return response()->json($gasto);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Gasto não encontrado.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $dados = $request->validate([
            'descricao' => 'required|string|max:500',
            'data' => 'required|date',
            'quantidade' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
            'compartilhado' => 'required|boolean',
            'repeticao' => 'required|boolean',
            'valor_dividido' => 'required|boolean',
            'anual' => 'required|boolean',
        ]);

        try {
            $gasto = $this->service->atualizar($id, $dados);
            return response()->json($gasto);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Gasto não encontrado.'], 404);
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
            return response()->json(['error' => 'Gasto não encontrado.'], 404);
        }
    }
}
