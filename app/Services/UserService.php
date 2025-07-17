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

    //Cria o Usuário
    public function create($data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userModel->create($data);

        return $user;
    }
}