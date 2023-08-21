<?php

namespace App\Http\Controllers\API\OwnerAndAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerAndAdmin\UserChaletAdminMessages\UserChaletsAdminMessageResource;
use App\Http\Resources\OwnerAndAdmin\UserChaletAdminMessages\UserResource;
use App\Http\Resources\OwnerAndAdmin\UserChaletAdminMessages\UsersHaveMessagesResource;
use App\Models\User;
use App\Models\UserChaletAdmin;
use App\Models\UserChaletAdminMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserChaletAdminMessageController extends Controller
{
    public function allUsersHaveMessages(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
        ]);

        if (!$validator->fails()) {

            $user = $request->user('sanctum');

            $userChaletAdminIsAdmin = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletAdminIsAdmin != null) {

                $users = User::whereHas('userChaletAdminMessages', function ($query) use ($request) {
                    $query->withTrashed()->whereHas('userChaletAdmin', function ($query) use ($request) {
                        $query->withTrashed()->where([
                            ['chalets_id', '=', $request->get('chalets_id')]
                        ]);
                    });
                })->get();

                return response()->json([
                    'status' => true,
                    'users_have_messages' => UsersHaveMessagesResource::collection($users),
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Does Not Owner or Admin',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function allMessages(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'users_id' => 'required|exists:users,id',
        ]);

        if (!$validator->fails()) {
            $user = $request->user('sanctum');

            $userChaletAdminIsAdmin = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletAdminIsAdmin != null) {
                $userChaletMessages = UserChaletAdminMessage::withTrashed()->where([
                    ['users_id', '=', $request->get('users_id')],
                ])->whereHas('userChaletAdmin.chalet', function ($query) use ($request) {
                    $query->where([
                        ['id', '=', $request->get('chalets_id')],
                    ]);
                },)->with([
                    'user',
                ])->orderBy('created_at')->get();

                $userMessaged = User::where([
                    ['id', '=', $request->get('users_id')],
                ])->first();

                return response()->json([
                    'status' => true,
                    'user' => UserResource::make($userMessaged),
                    'user_chalet_messages' => UserChaletsAdminMessageResource::collection($userChaletMessages),
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Does Not Owner or Admin',
                ], Response::HTTP_BAD_REQUEST);
            }
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
            'users_id' => 'required|exists:users,id',
            'message' => 'required|string|min:1|max:255',
        ]);

        if (!$validator->fails()) {

            $userChaletAdminIsAdmin = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletAdminIsAdmin != null) {

                $userChaletAdminMessage = new UserChaletAdminMessage();
                $userChaletAdminMessage->users_id = $request->get('users_id');
                $userChaletAdminMessage->user_chalet_admins_id = $userChaletAdminIsAdmin->id;
                $userChaletAdminMessage->message = $request->get('message');
                $userChaletAdminMessage->message_by = 'Admin';

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
                    'message' => 'User Does Not Owner or Admin',
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
            'chalets_id' => 'required|exists:chalets,id',
            'user_chalet_admin_messages_id' => 'required|exists:user_chalet_admin_messages,id',
        ]);

        if (!$validator->fails()) {

            $userChaletAdminIsAdmin = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletAdminIsAdmin != null) {

                $userChaletAdminMessage = UserChaletAdminMessage::where([
                    ['id', '=', $request->get('user_chalet_admin_messages_id')],
                    ['user_chalet_admins_id', '=', $userChaletAdminIsAdmin->id],
                    ['message_by', '=', 'Admin'],
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
                        'message' => 'This Message Owned By User',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Does Not Owner or Admin',
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
