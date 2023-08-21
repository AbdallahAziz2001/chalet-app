<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\LoginAndRegisterResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'username' => 'required_without_all:email,mobile|exists:users,username',
            'email' => 'required_without_all:username,mobile|exists:users,email',
            'mobile' => 'required_without_all:username,email|exists:users,mobile',
            'password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
        ], [
            'username.exists' => 'Login Failed, Wrong Credentials',
            'username.required_without_all' => 'Username, Email or Mobile is Required',
            'email.required_without_all' => 'Username, Email or Mobile is Required',
            'mobile.required_without_all' => 'Username, Email or Mobile is Required',
        ]);

        if (!$validator->fails()) {
            if ($request->has('username')) {
                $user = User::where('username', '=', $request->get('username'))->first();
            } elseif ($request->has('email')) {
                $user = User::where('email', '=', $request->get('email'))->first();
            } elseif ($request->has('mobile')) {
                $user = User::where('mobile', '=', $request->get('mobile'))->first();
            }

            if (Hash::check($request->get('password'), $user->password)) {
                $userIsUpdated = $user->update();
                $token = $user->createToken('User_Token');
                if ($userIsUpdated) {
                    $user->setAttribute('token', $token->plainTextToken);
                    return response()->json([
                        'status' => true,
                        'user' => LoginAndRegisterResource::make($user),
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to Change User FCM Token',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Login Failed, Wrong Credentials'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
