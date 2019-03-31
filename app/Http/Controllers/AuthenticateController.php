<?php

namespace App\Http\Controllers;
use App\User;
use App\TransactionCategory;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $payload = JWTAuth::getPayload($token);
        $expirationTime = $payload['exp'];
        $ready_token = [
            'token' => $token,
            'expires_in' => $expirationTime
        ];
        // all good so return the token
        return response($ready_token);
    }

    public function create(Request $request){
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $user = new User;

        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $category = new TransactionCategory;
        $category->name = "No category";
        $user->transactionCategories()->save($category);

        return 'User created!'; 
    }
}
