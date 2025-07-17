<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    //Cria o Usuário
    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->create($data);

        return response()->json([
            'error' => false,
            'message' => 'Usuário criado com sucesso.',
            'data' => $user
        ], 200);
    }

    //Retorna Usuários de acordo com o filtro
    public function getByFilter()
    {
        $name = request()->query('name');

        $users = User::query()
            ->name($name)
            ->get();

        return response()->json(['error' => false, 'usuarios' => $users]);
    }
}
