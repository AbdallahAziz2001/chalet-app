<?php

namespace App\Http\Controllers\API\OwnerAndAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerAndAdmin\UserChaletAdmins\UserChaletAdminResource;
use App\Models\User;
use App\Models\UserChaletAdmin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserChaletAdminController extends Controller
{
    public function userChaletAdmins(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
        ]);
        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletAdminIsOwner != null && $userChaletAdminIsOwner->is_owner == 1) {
                $users = User::whereHas('userChaletAdmins', function ($query) use ($request) {
                    $query->where('chalets_id', '=', $request->get('chalets_id'))->whereNull('deleted_at');
                })->get();

                return response()->json([
                    'status' => true,
                    'user_chalet_admins' => UserChaletAdminResource::collection($users),
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Does Not Owner',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function addUserChaletAdmins(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'users_username' => 'required|exists:users,username',
        ]);
        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletAdminIsOwner != null && $userChaletAdminIsOwner->is_owner == 1) {

                $userForAddToAdminList = User::where([
                    ['username', '=', $request->get('users_username')],
                ])->first();

                if ($userForAddToAdminList != null) {

                    $user_chalet_admin = UserChaletAdmin::withTrashed()->where([
                        ['users_id', '=', $userForAddToAdminList->id],
                        ['chalets_id', '=', $request->get('chalets_id')],
                    ])->restore();

                    if ($user_chalet_admin <= 0) {
                        $user_chalet_admin = new UserChaletAdmin();
                        $user_chalet_admin->users_id = $userForAddToAdminList->id;
                        $user_chalet_admin->chalets_id = $request->get('chalets_id');
                        $user_chalet_admin->is_owner = false;

                        $isSaved =  $user_chalet_admin->save();

                        if ($isSaved) {
                            return response()->json([
                                'status' => true,
                            ], Response::HTTP_OK);
                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'Failed to Save User to Chalet Admins',
                            ], Response::HTTP_BAD_REQUEST);
                        }
                    } else {
                        return response()->json([
                            'status' => true,
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'User Does Not Exists',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Does Not Owner',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteUserChaletAdmins(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'users_username' => 'required|exists:users,username',
        ]);
        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletAdminIsOwner != null && $userChaletAdminIsOwner->is_owner == 1) {
                $userForDeleteFromAdminList = User::where([
                    ['username', '=', $request->get('users_username')],
                ])->first();

                if ($userForDeleteFromAdminList != null) {
                    $user_chalet_admin = UserChaletAdmin::where([
                        ['users_id', '=', $userForDeleteFromAdminList->id],
                        ['chalets_id', '=', $request->get('chalets_id')],
                    ])->first();

                    $isDeleted =  $user_chalet_admin != null ? $user_chalet_admin->delete() : false;

                    if ($isDeleted) {
                        return response()->json([
                            'status' => true,
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Failed to Delete User from Chalet Admins',
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'User Does Not Exists',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Does Not Owner',
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
