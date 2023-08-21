<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserChaletAdminMessages\ChaletResource;
use App\Http\Resources\User\UserChaletAdminMessages\ChaletsHaveMessagesResource;
use App\Http\Resources\User\UserChaletAdminMessages\UserChaletsAdminMessageResource;
use App\Models\Chalet;
use App\Models\User;
use App\Models\UserChaletAdmin;
use App\Models\UserChaletAdminMessage;
use App\Models\UserChaletStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserChaletAdminMessageController extends Controller
{
    public function allChaletsHaveMessages(Request $request)
    {
        $user = $request->user('sanctum');

        $chalets = Chalet::whereHas('userChaletAdmins', function ($query) use ($user) {
            $query->withTrashed()->whereHas('userChaletAdminMessages', function ($query) use ($user) {
                $query->withTrashed()->where([
                    ['users_id', '=', $user->id]
                ])->orderBy('created_at');
            });
        })->get();

        foreach ($chalets as $chalet) {
            $owner = User::whereHas('userChaletAdmins', function ($query) use ($chalet) {
                $query->where([
                    ['chalets_id', '=', $chalet->id],
                    ['is_owner', '=', true],
                ]);
            })->first();
            $chalet->setAttribute('chalet_owner_fcm_token', $owner->fcm_token);
        }

        foreach ($chalets as $chalet) {
            $user_chalet_status = UserChaletStatus::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $chalet->id],
            ])->first();
            if ($user_chalet_status != null) {
                $chalet->setAttribute('user_chalet_status', $user_chalet_status->status);
            } else {
                $chalet->setAttribute('user_chalet_status', null);
            }
        }

        return response()->json([
            'status' => true,
            'chalets_have_messages' => ChaletsHaveMessagesResource::collection($chalets),
        ], Response::HTTP_OK);
    }

    public function allMessages(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
        ]);

        if (!$validator->fails()) {
            $userChaletMessages = UserChaletAdminMessage::withTrashed()->where([
                ['users_id', '=', $user->id],
            ])->whereHas('userChaletAdmin.chalet', function ($query) use ($request) {
                $query->where([
                    ['id', '=', $request->get('chalets_id')],
                ]);
            },)->orderBy('created_at')->get();

            $chalet = Chalet::where([
                ['id', '=', $request->get('chalets_id')]
            ])->first();

            $owner = User::whereHas('userChaletAdmins', function ($query) use ($chalet) {
                $query->where([
                    ['chalets_id', '=', $chalet->id],
                    ['is_owner', '=', true],
                ]);
            })->first();
            $chalet->setAttribute('chalet_owner_fcm_token', $owner->fcm_token);

            $user_chalet_status = UserChaletStatus::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $chalet->id],
            ])->first();
            if ($user_chalet_status != null) {
                $chalet->setAttribute('user_chalet_status', $user_chalet_status->status);
            } else {
                $chalet->setAttribute('user_chalet_status', null);
            }

            return response()->json([
                'status' => true,
                'chalet' => ChaletResource::make($chalet),
                'user_chalet_messages' => UserChaletsAdminMessageResource::collection($userChaletMessages),
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function sendMessage(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'message' => 'required|string|min:1|max:255',
        ]);

        if (!$validator->fails()) {

            $userChaetAdmin = UserChaletAdmin::where([
                ['chalets_id', '=', $request->get('chalets_id')],
                ['is_owner', '=', 1],
            ])->first();

            $userChaletAdminMessage = new UserChaletAdminMessage();
            $userChaletAdminMessage->users_id = $user->id;
            $userChaletAdminMessage->user_chalet_admins_id = $userChaetAdmin->id;
            $userChaletAdminMessage->message = $request->get('message');
            $userChaletAdminMessage->message_by = 'User';

            $userChaletAdminMessageIsSaved = $userChaletAdminMessage->save();

            if ($userChaletAdminMessageIsSaved) {
                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You Have Some Error',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteMessage(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'user_chalet_admin_messages_id' => 'required|exists:user_chalet_admin_messages,id',
        ]);

        if (!$validator->fails()) {

            $userChaletAdminMessage = UserChaletAdminMessage::where([
                ['id', '=', $request->get('user_chalet_admin_messages_id')],
                ['users_id', '=', $user->id],
                ['message_by', '=', 'User'],
            ])->first();

            if ($userChaletAdminMessage != null) {
                $userChaletAdminMessageIsDeleted = $userChaletAdminMessage->delete();

                if ($userChaletAdminMessageIsDeleted) {
                    return response()->json([
                        'status' => true,
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'You Have Some Error',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'This Message Owned By Chalet or Another User',
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
