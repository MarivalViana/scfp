<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Autenticar usuário e gerar token.
     */
    public function login(Request $request)
    {
        // 1. Validação dos dados
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Tentar autenticar o usuário
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        // 3. Buscar o usuário autenticado
        $user = User::where('email', $request->email)->firstOrFail();

        // 4. Gerar o token de acesso
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Revogar o token do usuário.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ]);
    }
}
