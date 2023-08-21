<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function showLogin(Request $request, $guard)
    {
        return response()->view('dashboard.auth.login', ['guard' => $guard]);
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'username' => 'required|string|min:3|max:50|exists:admins,username',
            'password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
            'remember' => 'required|boolean',
            'guard' => 'required|in:admin|string'
        ], [
            'guard.in' => 'Please, check url'
        ]);

        $credentials = ['username' => $request->get('username'), 'password' => $request->get('password')];
        if (!$validator->fails()) {
            if (Auth::guard($request->get('guard'))->attempt($credentials, $request->get('remember'))) {
                return response()->json(['message' => 'Logged in successfully'], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Error credentials, please try again'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }
}
