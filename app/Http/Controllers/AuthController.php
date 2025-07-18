<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first() 
            ?? throw new \Exception('Usuário não encontrado.', 404); 

        $credentials = [
            'email' => $user,
            'password' => $data['password']
        ];

        $token = JWTAuth::attempt($credentials)
            ?: throw new \Exception('Credenciais inválidas', 401);
        
        return $this->respondWithToken($token);
    }

    public function logout(): JsonResponse
    {
        if (!auth('api')->check()) {
            return response()->json(['error' => 'Token inválido ou expirado.'], 401);
        }

        auth('api')->logout();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ]);
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = Auth::user();
        $user->update(array_filter($request->validated()));

        return response()->json([
            'success' => true,
            'message' => 'Usuário atualizado com sucesso.',
            'user' => $user
        ]);
    }

    public function delete(): JsonResponse
    {
        Auth::user()->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Usuário deletado com sucesso.'
        ]);
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('api')->user(),
        ]);
    }
}
