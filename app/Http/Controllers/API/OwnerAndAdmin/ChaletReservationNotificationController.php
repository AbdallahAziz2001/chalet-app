<?php

namespace App\Http\Controllers\API\OwnerAndAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerAndAdmin\ChaletReservationNotifications\ChaletAcceptedReservationResource;
use App\Http\Resources\OwnerAndAdmin\ChaletReservationNotifications\ChaletCanceledReservationResource;
use App\Http\Resources\OwnerAndAdmin\ChaletReservationNotifications\ChaletCompletedReservationResource;
use App\Http\Resources\OwnerAndAdmin\ChaletReservationNotifications\ChaletPendingReservationResource;
use App\Models\ChaletAutomaticReservation;
use App\Models\ChaletReservation;
use App\Models\User;
use App\Models\UserChaletAdmin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChaletReservationNotificationController extends Controller
{
    public function chaletReservationNotifications(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
        ]);
        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {
                $chaletPendingReservations = ChaletReservation::where([
                    ['chalets_id', '=', $request->get('chalets_id')],
                    ['status', '=', 'Pending'],
                    ['object_type', '=', 'App\Models\ChaletAutomaticReservation'],
                ])->with([
                    'chaletReservationObject',
                    'chaletReservationObject.user',
                ])->get();

                for ($index = 0; $index < count($chaletPendingReservations); $index++) {
                    $chaletRatingUserSum = ChaletAutomaticReservation::where([
                        ['users_id', '=', $chaletPendingReservations[$index]['object']['user']['id']]
                    ])->sum('chalet_rating_user');

                    $chaletRatingUserCount = ChaletAutomaticReservation::where([
                        ['users_id', '=', $chaletPendingReservations[$index]['object']['user']['id']]
                    ])->count('chalet_rating_user');

                    $chaletPendingReservations[$index]['object']['user']->setAttribute('chalet_rating_user_sum', $chaletRatingUserSum);
                    $chaletPendingReservations[$index]['object']['user']->setAttribute('chalet_rating_user_count', $chaletRatingUserCount);
                }

                $chaletAcceptedReservations = ChaletReservation::where([
                    ['chalets_id', '=', $request->get('chalets_id')],
                    ['status', '=', 'Accepted'],
                ])->with([
                    'chaletReservationObject',
                ])->get();

                for ($index = 0; $index < count($chaletAcceptedReservations); $index++) {
                    if ($chaletAcceptedReservations[$index]['object_type'] == 'App\\Models\\ChaletAutomaticReservation') {
                        $userForSetAttribute = User::where([
                            ['id', '=', $chaletAcceptedReservations[$index]['object']['users_id']],
                        ])->first();
                        $chaletRatingUserSum = ChaletAutomaticReservation::where([
                            ['users_id', '=', $userForSetAttribute->id]
                        ])->sum('chalet_rating_user');

                        $chaletRatingUserCount = ChaletAutomaticReservation::where([
                            ['users_id', '=', $userForSetAttribute->id]
                        ])->count('chalet_rating_user');

                        $userForSetAttribute->setAttribute('chalet_rating_user_sum', $chaletRatingUserSum);
                        $userForSetAttribute->setAttribute('chalet_rating_user_count', $chaletRatingUserCount);

                        $chaletAcceptedReservations[$index]['object']->setAttribute('user', $userForSetAttribute);
                    }
                }

                $chaletCompletedReservations = ChaletReservation::where([
                    ['chalets_id', '=', $request->get('chalets_id')],
                    ['status', '=', 'Completed'],
                ])->with([
                    'chaletReservationObject',
                ])->get();

                for ($index = 0; $index < count($chaletCompletedReservations); $index++) {
                    if ($chaletCompletedReservations[$index]['object_type'] == 'App\\Models\\ChaletAutomaticReservation') {
                        $userForSetAttribute = User::where([
                            ['id', '=', $chaletCompletedReservations[$index]['object']['users_id']],
                        ])->first();
                        $chaletRatingUserSum = ChaletAutomaticReservation::where([
                            ['users_id', '=', $userForSetAttribute->id]
                        ])->sum('chalet_rating_user');

                        $chaletRatingUserCount = ChaletAutomaticReservation::where([
                            ['users_id', '=', $userForSetAttribute->id]
                        ])->count('chalet_rating_user');

                        $userForSetAttribute->setAttribute('chalet_rating_user_sum', $chaletRatingUserSum);
                        $userForSetAttribute->setAttribute('chalet_rating_user_count', $chaletRatingUserCount);

                        $chaletCompletedReservations[$index]['object']->setAttribute('user', $userForSetAttribute);
                    }
                }

                $chaletCanceledReservations = ChaletReservation::where([
                    ['chalets_id', '=', $request->get('chalets_id')],
                    ['status', '=', 'Canceled'],
                ])->with([
                    'chaletReservationObject',
                ])->get();

                for ($index = 0; $index < count($chaletCanceledReservations); $index++) {
                    if ($chaletCanceledReservations[$index]['object_type'] == 'App\\Models\\ChaletAutomaticReservation') {
                        $userForSetAttribute = User::where([
                            ['id', '=', $chaletCanceledReservations[$index]['object']['users_id']],
                        ])->first();
                        $chaletRatingUserSum = ChaletAutomaticReservation::where([
                            ['users_id', '=', $userForSetAttribute->id]
                        ])->sum('chalet_rating_user');

                        $chaletRatingUserCount = ChaletAutomaticReservation::where([
                            ['users_id', '=', $userForSetAttribute->id]
                        ])->count('chalet_rating_user');

                        $userForSetAttribute->setAttribute('chalet_rating_user_sum', $chaletRatingUserSum);
                        $userForSetAttribute->setAttribute('chalet_rating_user_count', $chaletRatingUserCount);

                        $chaletCanceledReservations[$index]['object']->setAttribute('user', $userForSetAttribute);
                    }
                }

                return response()->json([
                    'status' => true,
                    'chalet_pending_reservations' => ChaletPendingReservationResource::collection($chaletPendingReservations),
                    'chalet_Accepted_reservations' => ChaletAcceptedReservationResource::collection($chaletAcceptedReservations),
                    'chalet_Completed_reservations' => ChaletCompletedReservationResource::collection($chaletCompletedReservations),
                    'chalet_Canceled_reservations' => ChaletCanceledReservationResource::collection($chaletCanceledReservations),
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Does Admin in This Chalet',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function chaletReservationChangeStatus(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'chalet_reservations_id' => 'required|exists:chalet_reservations,id',
            'status' => 'required|in:Pending,Accepted,Completed,Canceled',
        ]);

        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {

                $chaletReservation = ChaletReservation::where([
                    ['id', '=', $request->get('chalet_reservations_id')],
                ])->first();

                $chaletReservationIsUpdated = ChaletReservation::where('id', '=', $request->get('chalet_reservations_id'))
                    ->update(['status' => $request->get('status')]);

                if ($chaletReservationIsUpdated > 0) {
                    return response()->json([
                        'status' => true,
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'You Have Some Error, Pls Try Again',
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Does Admin in This Chalet',
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
