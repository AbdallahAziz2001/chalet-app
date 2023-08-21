<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class VerifyEmailController extends Controller
{
    public function emailVerifiedView($email_verifications_id, $users_id, $hash, $expiration)
    {

        DB::table('email_verifications')->where([
            ['expired_at', '<', now()],
        ])->delete();

        $emailVerification = DB::table('email_verifications')->select()->where([
            ['id', '=', $email_verifications_id],
            ['users_id', '=', $users_id],
            ['hash', '=', $hash],
            ['expired_at', '=', $expiration],
            ['expired_at', '>=', now()],
        ])->first();

        if ($emailVerification != null) {

            DB::table('email_verifications')->where([
                ['id', '=', $email_verifications_id],
                ['users_id', '=', $users_id],
                ['hash', '=', $hash],
                ['expired_at', '=', $expiration],
            ])->delete();

            $user = User::find($users_id);
            if ($user != null) {
                $user->email_verified_at = now();
                $userIsUpdated = $user->update();
                if ($userIsUpdated) {
                    return response()->view('emails.email_verified');
                } else {
                    return response()->view('emails.email_verified_error', ['message' => 'Email Not Verified Try Again']);
                }
            } else {
                return response()->view('emails.email_verified_error', ['message' => 'URL Invalid or URL Expired']);
            }
        } else {
            return response()->view('emails.email_verified_error', ['message' => 'URL Invalid or URL Expired']);
        }
    }
}
