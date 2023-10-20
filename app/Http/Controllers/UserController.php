<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Settings\PlatformSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

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


    public function getPlatformSettings(PlatformSettings $platformSettings)
    {

        return response()->json([
            'settings' => [
                'product_one_price' => $platformSettings->product_one_price,
                'product_one_title' => $platformSettings->product_one_title,
                'product_one_description' => $platformSettings->product_one_description,
                'product_two_price' => $platformSettings->product_two_price,
                'product_two_title' => $platformSettings->product_two_title,
                'product_two_description' => $platformSettings->product_two_description,
                'product_three_price' => $platformSettings->product_three_price,
                'product_three_title' => $platformSettings->product_three_title,
                'product_three_description' => $platformSettings->product_three_description,
                'affiliate_percentage' => $platformSettings->affiliate_percentage,
                'affiliate_minimum_withdrawal' => $platformSettings->affiliate_minimum_withdrawal,
                'minimum_withdrawal' => $platformSettings->minimum_withdrawal,
                'site_name' => $platformSettings->site_name,
                'site_description' => $platformSettings->site_description,
                'lock_purchases' => $platformSettings->lock_purchases,
                'lock_withdrawals' => $platformSettings->lock_withdrawals,
                'lock_referrals' => $platformSettings->lock_referrals,

            ]
        ], 200);
    }


    public function user()
    {
        $user = auth()->user();

        return $user;
    }

    public function updateBankDetails(Request $request)
    {

        $request->validate([
            'bank_name' => 'required|string|min:5',
            'account_name' => 'required|string|min:5|max:50',
            'account_number' => 'required|min:10|max:10',
        ]);
        $user = auth()->user();


        $user->update([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return response()->json([
            'message' => 'Bank details updated successfully',
            'user' => $user
        ], 200);
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address_city' => 'required|string|min:5',
            'address_state' => 'required|string|min:5',
        ]);
        $user = auth()->user();

        $user->update([
            'address_city' => $request->address_city,
            'address_state' => $request->address_state,
        ]);

        return response()->json([
            'message' => 'Address updated successfully',
            'user' => $user
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',

        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Old password is incorrect'
            ], 401);
        }

        $user->update([
            'password' => $request->new_password
        ]);

        return response()->json([
            'message' => 'Password changed successfully'
        ], 200);
    }
}
