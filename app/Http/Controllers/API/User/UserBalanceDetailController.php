<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\UserBalanceDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserBalanceDetailController extends Controller
{
    public function userBalanceDetails(Request $request)
    {
        $user = $request->user('sanctum');
        $userBalanceDetails = UserBalanceDetail::select('balance', 'details', 'type', 'created_at')->orderBy('created_at', 'DESC')->where('users_id', '=', $user->id)->get();
        return response()->json([
            'status' => true,
            'user_balance_details' => $userBalanceDetails,
        ], Response::HTTP_OK);
    }

    public function addUserBalanceDetails(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'balance' => 'required|numeric|between:0,999999.99',
            'details' => 'required|string|min:3|max:255',
            'type' => 'required|in:Withdraw,Deposit',
        ]);

        if (!$validator->fails()) {
            $user_balance_detail = new UserBalanceDetail();
            $user_balance_detail->users_id = $user->id;
            $user_balance_detail->balance = $request->get('balance');
            $user_balance_detail->details = $request->get('details');
            $user_balance_detail->type = $request->get('type');

            $isSaved = $user_balance_detail->save();

            if ($request->get('type') == 'Withdraw') {
                $user->balance = $user->balance - $user_balance_detail->balance;
            } else if ($request->get('type') == 'Deposit') {
                $user->balance = $user->balance + $user_balance_detail->balance;
            }

            $isUpdated = $user->update();

            if ($isSaved && $isUpdated) {
                return response()->json([
                    'status' => true,
                    'message' => 'User Balance Detail Saved Successfully',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Save User Balance Detail',
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
