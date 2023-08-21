<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $user = $request->user('sanctum');
        $user->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
        ], Response::HTTP_OK);
    }
}
