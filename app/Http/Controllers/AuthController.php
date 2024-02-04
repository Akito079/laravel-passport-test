<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //JWT login
    public function login(Request $request){
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
            ],422);
        }
        if(!auth()->attempt($requestData)){
            return response()->json(["error" => "Unauthorized Request"],401);
        }
        $accessToken = auth()->user()->createToken("auth_token")->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken], 200);
    }
    public function register(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $requestData['password'] = Hash::make($requestData['password']);

        $user = User::create($requestData);

        return response([ 'status' => true, 'message' => 'User successfully register.' ], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => $user], 200);
    }
    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    //google login redirect
    public function redirectTogoogle(){
        return Socialite::driver('google')->redirect();
    }

    // Handle the callback from Google
    public function handleGoogleCallback()
    {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::updateOrCreate([
                'id' => $googleUser->id,
            ],[
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => 'something',
                'access_token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken,
            ]);
            Auth::login($user);
            return redirect('/');
    }
}
