<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserChaletStatuses\UserChaletBlockResource;
use App\Http\Resources\User\UserChaletStatuses\UserChaletFavoriteResource;
use App\Models\UserChaletStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserChaletStatusController extends Controller
{
    public function userChaletFavoriteStatus(Request $request)
    {
        $user = $request->user('sanctum');

        $userChaletFavoriteStatus = $user->userChaletStatusChalets()->where([
            ['status', '=', 'Favorite'],
        ])->with([
            'chaletImages' => function ($query) {
                $query->select('id', 'chalets_id', 'order', 'image')->orderBy('order');
            },
        ])->withCount('chaletReservations')->get();

        return response()->json([
            'status' => true,
            'chalets' => UserChaletFavoriteResource::collection($userChaletFavoriteStatus),
        ], Response::HTTP_OK);
    }

    public function addUserChaletFavoriteStatus(Request $request)
    {
        $user = $request->user('sanctum');

        if ($request->has(['chalets_id'])) {
            $userChaletStatusIsExists = UserChaletStatus::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();


            if ($userChaletStatusIsExists === null) {
                $validator = Validator($request->all(), [
                    'chalets_id' => 'required|exists:chalets,id',
                ]);

                if (!$validator->fails()) {
                    $userChaletStatus = new UserChaletStatus();
                    $userChaletStatus->users_id = $user->id;
                    $userChaletStatus->chalets_id = $request->get('chalets_id');
                    $userChaletStatus->status = 'Favorite';

                    $isSaved =  $userChaletStatus->save();

                    if ($isSaved) {
                        return response()->json([
                            'status' => true,
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Failed to Save User Chalet Favorite',
                        ], Response::HTTP_OK);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => $validator->getMessageBag()->first(),
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else if ($userChaletStatusIsExists->status == 'Block') {
                return response()->json([
                    'status' => false,
                    'message' => 'User Block Chalet Check BlockList',
                ], Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Chalet Favorite is Already Exists',
                ], Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public function deleteUserChaletFavoriteStatus(Request $request)
    {
        $user = $request->user('sanctum');

        if ($request->has(['chalets_id'])) {

            $userChaletStatus = UserChaletStatus::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletStatus !== null) {
                $validator = Validator($request->all(), [
                    'chalets_id' => 'required|exists:chalets,id',
                ]);

                if (!$validator->fails()) {
                    $isDeleted =  $userChaletStatus != null ? $userChaletStatus->delete() : false;

                    if ($isDeleted) {
                        return response()->json([
                            'status' => true,
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Failed to Delete User Chalet Favorite',
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => $validator->getMessageBag()->first()
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Chalet Favorite is Already Not Exists',
                ], Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public function userChaletBlockStatus(Request $request)
    {
        $user = $request->user('sanctum');

        $userChaletBlockStatus = $user->userChaletStatusChalets()->where([
            ['status', '=', 'Block'],
        ])->get();

        return response()->json([
            'status' => true,
            'chalets' => UserChaletBlockResource::collection($userChaletBlockStatus),
        ], Response::HTTP_OK);
    }

    public function addUserChaletBlockStatus(Request $request)
    {
        $user = $request->user('sanctum');

        if ($request->has(['chalets_id'])) {
            $userChaletStatusIsExists = UserChaletStatus::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();


            if ($userChaletStatusIsExists === null) {
                $validator = Validator($request->all(), [
                    'chalets_id' => 'required|exists:chalets,id',
                ]);

                if (!$validator->fails()) {
                    $userChaletStatus = new UserChaletStatus();
                    $userChaletStatus->users_id = $user->id;
                    $userChaletStatus->chalets_id = $request->get('chalets_id');
                    $userChaletStatus->status = 'Block';

                    $isSaved =  $userChaletStatus->save();

                    if ($isSaved) {
                        return response()->json([
                            'status' => true,
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Failed to Save User Chalet Block',
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
                }
            } else if ($userChaletStatusIsExists->status == 'Favorite') {
                $userChaletStatusIsExists->status = 'Block';

                $isUpdated =  $userChaletStatusIsExists->update();

                if ($isUpdated) {
                    return response()->json([
                        'status' => true,
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to Save User Chalet Block',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Chalet Block is Already Exists',
                ], Response::HTTP_BAD_REQUEST);
            }
        }
    }

    public function deleteUserChaletBlockStatus(Request $request)
    {
        $user = $request->user('sanctum');

        if ($request->has(['chalets_id'])) {

            $userChaletStatus = UserChaletStatus::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userChaletStatus !== null) {
                $validator = Validator($request->all(), [
                    'chalets_id' => 'required|exists:chalets,id',
                ]);

                if (!$validator->fails()) {
                    $isDeleted =  $userChaletStatus != null ? $userChaletStatus->delete() : false;

                    if ($isDeleted) {
                        return response()->json([
                            'status' => true,
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Failed to Delete User Chalet Block',
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => $validator->getMessageBag()->first(),
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Chalet Block is Already Not Exists',
                ], Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
