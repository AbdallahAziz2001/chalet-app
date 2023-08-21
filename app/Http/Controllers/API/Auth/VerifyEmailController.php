<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class VerifyEmailController extends Controller
{
    public static function generateEmailVerifyUrl(User $user)
    {
        $expiration = now()->addMinutes(60);
        $hash = Str::random(64);

        DB::table('email_verifications')->insert([
            'users_id' => $user->id,
            'hash' => $hash,
            'expired_at' => $expiration,
        ]);

        $emailVerification = DB::table('email_verifications')->select()->where([
            ['users_id', '=', $user->id],
            ['hash', '=', $hash],
            ['expired_at', '=', $expiration],
        ])->first();

        $emailVerifyUrl = URL::temporarySignedRoute(
            'email_verified',
            $expiration,
            [
                'email_verifications_id' => $emailVerification->id,
                'users_id' => $user->id,
                'hash' => $hash,
                'expiration' => $expiration,
            ],
        );

        return $emailVerifyUrl;
    }

    public function sendVerifyEmail(Request $request)
    {
        $user = $request->user('sanctum');

        if ($user->email_verified_at == NULL) {
            $emailVerifyUrl = VerifyEmailController::generateEmailVerifyUrl($user);
            Mail::to($user->email, $user->first_name . ' ' . $user->last_name)->send(new VerificationEmail($emailVerifyUrl));

            return response()->json([
                'status' => true,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'This Email is Already Verified',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
