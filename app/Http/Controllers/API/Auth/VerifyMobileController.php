<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Credentials\Container;
use Vonage\Verify\Request as VerifyRequest;

class VerifyMobileController extends Controller
{
    public function verifyMobileNotifyCode(Request $request)
    {
        $validator = Validator($request->all(), [
            'mobile' => 'required|regex:/^([0-9]*)$/|min:8|max:25|unique:users,mobile',
        ]);

        if (!$validator->fails()) {
            $basic  = new Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
            $client = new Client(new Container($basic), ['verify' => false]);

            $to = $request->get('mobile');

            $request = new VerifyRequest($to, "Chalet App");
            $response = $client->verify()->start($request);

            return response()->json([
                'status' => true,
                'request_id' => $response->getRequestId(),
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function verifyMobileCheckNotifyCode(Request $request)
    {
        $validator = Validator($request->all(), [
            'request_id' => 'required',
            'verify_code' => 'required',
        ]);

        if (!$validator->fails()) {

            $basic  = new Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
            $client = new Client(new Container($basic), ['verify' => false]);

            $client->verify()->check($request->get('request_id'), $request->get('verify_code'));

            return response()->json([
                'status' => true,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
