<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Credentials\Container;
use Vonage\SMS\Message\SMS;

class GeneratePasswordController extends Controller
{
    public function generatePassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'username' => 'required|exists:users,username',
            'email' => 'nullable|exists:users,email',
            'mobile' => 'required|exists:users,mobile',
        ], [
            'username.exists' => 'Wrong Credentials',
            'email.exists' => 'Wrong Credentials',
            'mobile.exists' => 'Wrong Credentials',
        ]);

        if (!$validator->fails()) {

            if ($request->has('email')) {
                $user = User::where([
                    ['username', '=', $request->get('username')],
                    ['email', '=', $request->get('email')],
                    ['mobile', '=', $request->get('mobile')],
                ])->first();
            } else {
                $user = User::where([
                    ['username', '=', $request->get('username')],
                    ['email', '=', NULL],
                    ['mobile', '=', $request->get('mobile')],
                ])->first();
            }

            if ($user != null) {

                $customSymbols = ['?', '=', '.', '*', '[', '*', '.', '!', '@', '$', '%', '^', '&', '(', ')', '{', '}', ']'];
                $customNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                $generatePassword = Str::random(15);

                $generatePasswordRandomForInsertSymbol = rand(2, (strlen($generatePassword) - 2));
                $generatePassword = substr_replace($generatePassword, $customSymbols[rand(0, (count($customSymbols) - 1))], $generatePasswordRandomForInsertSymbol, 1);

                $generatePasswordRandomForInsertNumber = rand(2, (strlen($generatePassword) - 2));
                $generatePassword = substr_replace($generatePassword, $customNumbers[rand(0, (count($customNumbers) - 1))], $generatePasswordRandomForInsertNumber, 1);

                $user->password = Hash::make($generatePassword);

                $isUpdated = $user->update();

                if ($isUpdated) {
                    $basic  = new Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
                    $client = new Client(new Container($basic), ['verify' => false]);

                    $response = $client->sms()->send(
                        new SMS($request->get('mobile'), 'Chalet App', 'Your Generate Password is ' . $generatePassword)
                    );
                    $message = $response->current();

                    if ($message->getStatus() == 0) {
                        return response()->json([
                            'status' => true,
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'The message failed with status: ' . $message->getStatus(),
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to Generate Password',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You Have an Error',
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
