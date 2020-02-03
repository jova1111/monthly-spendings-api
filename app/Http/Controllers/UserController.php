<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JWTAuth;

class UserController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
    }

    public function authenticate(LoginUserRequest $request)
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

    /**
     * Returns list of years in which user created transactions
     */
    public function getActiveYears($id)
    {
        $userId = $id;
        if ($id == 'me') {
            $userId = auth()->user()->id;
        }
        $activeYears = $this->userService->getActiveYears($userId);
        return response($activeYears);
    }

    public function getAll()
    {
        $users = $this->userService->getAll();
        return response($users);
    }
}
