<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Services\UserService;

class AuthController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(StoreUserRequest $request)
    {
        $user = $this->userService->create($request->validated());

        if ($user) {
            return response()->json(['success' => 1, 'message' => 'User was created']);
        } else {
            return response()->json(['success' => 0, 'message' => 'User was not created'], 500);
        }
    }

    public function login(LoginUserRequest $request)
    {
        $token = $this->userService->loginUser($request->validated());

        if ($token) {
            return response()->json($token);
        } else {
            return response()->json(['success' => 0, 'message' => 'User not found'], 500);
        }
    }
}
