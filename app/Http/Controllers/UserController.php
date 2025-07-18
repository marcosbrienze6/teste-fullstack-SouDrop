<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    //Cria o Usuário
    public function create(Request $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->userService->create($data);

        return response()->json([
            'error' => false,
            'message' => 'Usuário criado com sucesso.',
            'data' => $user
        ], 200);
    }
}
