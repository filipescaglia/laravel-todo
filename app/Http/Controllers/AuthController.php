<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function create(Request $request)
    {
        $response = ['error' => ''];

        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $response['error'] = $validator->messages();
            return $response;
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = new User();
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->token = '';
        $user->save();

        return $response;
    }

    public function login(Request $request)
    {
        $response = ['error' => ''];

        $creds = $request->only('email', 'password');

        if(Auth::attempt($creds)) {

            $user = User::where('email', $creds['email'])->first();

            $item = time().rand(0, 9999);
            $token = $user->createToken($item)->plainTextToken;

            $response['token'] = $token;

        } else $response['error'] = "E-mail or password incorrect.";

        return $response;
    }

    public function logout(Request $request)
    {
        $response = ['error' => ''];

        $user = $request->user();
        $user->tokens()->delete();

        return $response;
    }
}
