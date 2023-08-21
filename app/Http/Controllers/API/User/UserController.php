<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\Auth\VerifyEmailController;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserReservations\UserReservationResource;
use App\Mail\VerificationEmail;
use App\Models\ChaletAutomaticReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function userReservations(Request $request)
    {

        $user = $request->user('sanctum');

        $chaletAutomaticReservations = ChaletAutomaticReservation::where([
            ['users_id', '=', $user->id],
        ])->whereHas(
            'chaletReservation',
            function ($query) {
                $query->whereBetween(
                    'start_at',
                    [
                        Carbon::parse('Now -75 days')->format('Y-m-d'),
                        Carbon::parse('Now +75 days')->format('Y-m-d')
                    ]
                )->where(function ($query) {
                    $query->where([
                        ['status', '=', 'Pending'],
                    ])->orWhere([
                        ['status', '=', 'Accepted'],
                    ])->orWhere([
                        ['status', '=', 'Completed'],
                    ]);
                });
            }
        )->with([
            'chaletReservation' => function ($query) {
                $query->whereBetween(
                    'start_at',
                    [
                        Carbon::parse('Now -75 days')->format('Y-m-d'),
                        Carbon::parse('Now +75 days')->format('Y-m-d')
                    ]
                )->where(function ($query) {
                    $query->where([
                        ['status', '=', 'Pending'],
                    ])->orWhere([
                        ['status', '=', 'Accepted'],
                    ])->orWhere([
                        ['status', '=', 'Completed'],
                    ]);
                })->with('chalet');
            }
        ])->get();

        return response()->json([
            'status' => true,
            'chalet_automatic_reservations' => UserReservationResource::collection($chaletAutomaticReservations),
        ], Response::HTTP_OK);
    }

    public function userProfileDetails(Request $request)
    {
        $user = $request->user('sanctum');

        $chaletAutomaticReservationsCount = ChaletAutomaticReservation::where([
            ['users_id', '=', $user->id],
        ])->whereHas(
            'chaletReservation',
            function ($query) {
                $query->where(function ($query) {
                    $query->Where([
                        ['status', '=', 'Completed'],
                    ]);
                });
            }
        )->count();

        return response()->json([
            'status' => true,
            'chalet_automatic_reservations_count' => $chaletAutomaticReservationsCount,
            'balance' => $user->balance,
        ], Response::HTTP_OK);
    }

    public function userProfileChangeFirstName(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'first_name' => 'required|string|min:3|max:50',
        ]);

        if (!$validator->fails()) {
            $user->first_name = $request->get('first_name');

            $isUpdated = $user->update();

            if ($isUpdated) {
                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Change User Profile',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userProfileChangeLastName(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'last_name' => 'required|string|min:3|max:50',
        ]);

        if (!$validator->fails()) {
            $user->last_name = $request->get('last_name');

            $isUpdated = $user->update();

            if ($isUpdated) {
                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Change User Profile',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userProfileChangeUsername(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'username' => 'required|string|min:3|max:50|unique:users,username',
        ]);

        if (!$validator->fails()) {
            $user->username = $request->get('username');

            $isUpdated = $user->update();

            if ($isUpdated) {
                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Change User Profile',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userProfileChangeEmail(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'email' => 'nullable|email|string|min:10|max:191|unique:users,email',
        ]);

        if (!$validator->fails()) {
            $user->email = $request->get('email');

            $isUpdated = $user->update();

            if ($isUpdated) {

                $emailVerifyUrl = VerifyEmailController::generateEmailVerifyUrl($user);
                Mail::to($request->get('email'), $user->first_name . ' ' . $user->last_name)->send(new VerificationEmail($emailVerifyUrl));

                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Change User Profile',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userProfileChangeMobile(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'mobile' => 'required|regex:/^([0-9]*)$/|min:8|max:25|unique:users,mobile',
        ]);

        if (!$validator->fails()) {
            $user->mobile = $request->get('mobile');

            $isUpdated = $user->update();

            if ($isUpdated) {
                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Change User Profile',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userProfileChangePassword(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'current_password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
            'new_password' => 'required|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
            'new_password_confirmation' => 'required_with:new_password|same:new_password|min:8|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
        ]);

        if (Hash::check($request->get('current_password'), $user->password)) {
            if (!$validator->fails()) {
                $user->password = Hash::make($request->get('new_password'));

                $isUpdated = $user->update();

                if ($isUpdated) {
                    return response()->json([
                        'status' => true,
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to Change User Profile',
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
                'message' => 'Your Current Password Incorrect',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userProfileChangeGender(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'gender' => 'required|in:Male,Female',

        ]);

        if (!$validator->fails()) {
            $user->gender = $request->get('gender');

            $isUpdated = $user->update();

            if ($isUpdated) {
                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Change User Profile',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userProfileChangeBirthday(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'birthday' => 'required|date_format:Y-m-d|before:18 years ago',
        ]);

        if (!$validator->fails()) {
            $user->birthday = $request->get('birthday');

            $isUpdated = $user->update();

            if ($isUpdated) {
                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Change User Profile'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function userProfileChangePicture(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'account_picture' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if (!$validator->fails()) {

            $previousAccounrPicture = 'public/users/' . $user->account_picture;
            $isPublicPicture = $user->account_picture != 'user_profile.png';

            $image = $request->file('account_picture');
            $account_picture = time() . '_' . $user->first_name . '_' . $user->last_name . '.' . $image->getClientOriginalExtension();
            $request->file('account_picture')->storePubliclyAs('users', $account_picture, ['disk' => 'public']);
            $user->account_picture = $account_picture;
            $isUpdated = $user->update();

            $account_picture_request = url('/') . Storage::url('users/' . $account_picture);

            if ($isUpdated) {
                if ($isPublicPicture && Storage::exists($previousAccounrPicture)) {
                    Storage::delete($previousAccounrPicture);
                }
                return response()->json([
                    'status' => true,
                    'account_picture' => $account_picture_request,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to Change User Profile'
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
