<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\registerRequest;

class AuthController extends Controller
{
//LogIn
public function login(LoginRequest $request)
{
    $user =   User::where('email',$request->email)->first();

      if($user && Hash::check($request->password,$user->password))
      {
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user'  => $user
         ],201);
    }
    return response()->json([
        'invalid token'
    ],401);

}

// Registration
  public function register(registerRequest $request)
  {
    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' =>Hash::make($request->password),
    ]);

    return response()->json([
        "user create done"
    ],201);
  }
}

