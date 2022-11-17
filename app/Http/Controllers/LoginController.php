<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function login(Request $request)
    {
       $login =  $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if(!Auth::attempt($login))
        {
            return response(['message'=>'inValid Login']);
        }
        $user = Auth::user();
        $accessToken = $user->createToken('clientAccess')->accessToken;
        return response(['user' => Auth::user(),'access_token'=>$accessToken]);
    }
}
