<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showChangePassword(Request $request)
    {
        return response()->view('dashboard.auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
            'new_password' => 'required_with:password|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/|confirmed',
        ]);

        if (!$validator->fails()) {
            $admin = $request->user('admin');
            $admin->password = Hash::make($request->get('new_password'));
            $isSaved = $admin->save();
            return response()->json(['message' => $isSaved ? 'Password changed successfully' : 'Failed to change password'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }
}
