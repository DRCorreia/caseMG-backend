<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        // Validar se o usuário existe e se as senhas são iguais
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        //Prepara o token para o retorno
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        info($request);
        // Verificar se o usuário está autenticado e se há um token atual
        if ($request->user() && $request->user()->currentAccessToken()) {
            // Deletar o token atual
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true
            ]);
        } else {
            // Retornar um erro de não autorizado se não houver token presente
            return response()->json([
                'success' => false
            ], 401); 
        }
    }

}
