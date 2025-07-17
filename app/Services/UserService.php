<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    //Gera o token JWT
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth('api')->user(),
        ]);
    }

    //Cria o Usuário
    public function create($data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userModel->create($data);
        
        return $user;
    }
}