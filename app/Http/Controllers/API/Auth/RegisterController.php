<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\LoginAndRegisterResource;
use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator($request->all(), [
            'first_name' => 'required|string|min:3|max:50',
            'last_name' => 'required|string|min:3|max:50',
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'email' => 'nullable|email|string|min:10|max:191|unique:users,email',
            'mobile' => 'required|regex:/^([0-9]*)$/|min:8|max:25|unique:users,mobile',
            'password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
            'password_confirmation' => 'required_with:password|same:password|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
            'fcm_token' => 'required|unique:users,fcm_token'
        ]);

        if (!$validator->fails()) {
            $user = new User();
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->username = $request->get('username');
            if ($request->has('email')) {
                $user->email = $request->get('email');
            }
            $user->mobile = $request->get('mobile');
            $user->password = Hash::make($request->get('password'));
            $user->balance = 0;
            $user->account_picture = 'user_profile.png';
            $user->fcm_token = $request->get('fcm_token');

            $isSaved = $user->save();

            if ($isSaved) {

                if ($request->has('email')) {
                    $emailVerifyUrl = VerifyEmailController::generateEmailVerifyUrl($user);
                    Mail::to($user->email, $user->first_name . ' ' . $user->last_name)->send(new VerificationEmail($emailVerifyUrl));
                }

                $token = $user->createToken('User_Token');
                $user->setAttribute('token', $token->plainTextToken);
                return response()->json([
                    'status' => true,
                    'user' => LoginAndRegisterResource::make($user),
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Register User',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
