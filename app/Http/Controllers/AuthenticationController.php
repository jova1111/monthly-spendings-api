<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\Contracts\UserService;
use Illuminate\Http\Request;
use JWTAuth;

class AuthenticationController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function authenticate(Request $request)
    {
        // handle exceptions in middleware (TokenExpiredException)
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Wrong credentials given.'], 401);
        }
        $payload = JWTAuth::setToken($token)->getPayload();
        $expirationTime = $payload['exp'];
        $tokenResponse = [
            'token' => $token,
            'expires_in' => $expirationTime,
        ];
        return response($tokenResponse);
    }

    public function create(CreateUserRequest $request)
    {
        $user = new User;
        $user->setUsername($request->username);
        $user->setEmail($request->email);
        $user->setPassword(bcrypt($request->password));
        $this->userService->create($user);
        return response()->json(['message' => 'User created!'], 201);
    }
}
