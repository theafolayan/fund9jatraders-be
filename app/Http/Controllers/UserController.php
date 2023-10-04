<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // register

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string',
            'address_city' => 'required|string',
            'address_state' => 'required|string',
            'password' => 'required|string|min:8',

        ]);

        $referral_id = $request->referral_id;


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address_city' => $request->address_city,
            'address_state' => $request->address_state,
            'password' => $request->password,
            'referrer_id' => $referral_id,
        ]);


        //create sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }


    // login user

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        //check if user exists

        $user = User::where('email', $request->email)->first();



        //check if password is correct

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        //create sanctum token

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    //reset password

    //update profile

    // register with referral


}
