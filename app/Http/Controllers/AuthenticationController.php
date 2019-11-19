<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser;
use App\Models\User;
use App\Services\Contracts\UserService;
use Illuminate\Http\Request;
use JWTAuth;

class AuthenticationController extends Controller
{
    private $_userService;

    public function __construct(UserService $userService)
    {
        $this->_userService = $userService;
    }

    public function authenticate(Request $request)
    {
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

    public function create(CreateUser $request)
    {
        $user = new User;
        $user->setUsername($request->username);
        $user->setEmail($request->email);
        $user->setPassword(bcrypt($request->password));
        $this->_userService->create($user);
        return response()->json(['message' => 'User created!'], 201);
    }

    public function test()
    {
        dd(auth()->user());
        return response()->json(['message' => 'Successful!']);
    }
}
