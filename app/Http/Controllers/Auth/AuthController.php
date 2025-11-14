<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function handleLogin ( Request $request){
        // validate user input
        $request->validate([
            // 'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255',
            'password' => 'required|string|max:255'
        ]);

        // check for the user details
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Invalid Login details, please check and retry again'
            ], 422);
        } 
        else{
            $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

            return response()->json([
                'message' => 'Login Successful',
                'token_Type' => 'Bearer',
                'token' => $token
            ], 200);
        }
    }


    // Admin registration logic handler
    public function handleRegister(Request $request){
        // validate input fields
            $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255',
            'password' => 'required|string|min:8'
            ]);
            

            $user = User::create([
                'name' => $request->name,
                'email' =>$request->email,
                'password' => Hash::make($request->password)
            ]);

            // create a Auth token for admin
            $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

            return response()->json([
                'message' => 'Admin Registered Successfully',
                'token_Type' => 'Bearer',
                'token' => $token,
                'data' => $user
            ], 201);

    }

}
