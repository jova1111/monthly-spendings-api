<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RegisterController extends Controller
{


    public function create(Request $request){
        error_log('Rip');
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);
        // Validate the request...

        /*$user = new User;

        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();*/
        return 'User created!'; 
    }
    public function test(){
        error_log('RIPic');
        return 'Braoo';
    }
}