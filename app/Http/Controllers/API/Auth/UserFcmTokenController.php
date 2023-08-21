<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserFcmTokenController extends Controller
{
    public function userFcmToken(Request $request)
    {
        $user = $request->user('sanctum');
        return response()->json([
            'status' => true,
            'fcm_token' => $user->fcm_token,
        ], Response::HTTP_OK);
    }

    public function changeUserFcmToken(Request $request)
    {
        $validator = Validator($request->all(), [
            'fcm_token' => 'required|unique:users,fcm_token'
        ]);

        if (!$validator->fails()) {

            $user = $request->user('sanctum');
            $user->fcm_token = $request->get('fcm_token');

            $userIsUpdated = $user->update();

            if ($userIsUpdated) {
                return response()->json([
                    'status' => true,
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
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
