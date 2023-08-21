<?php

namespace App\Http\Controllers\API\OwnerAndAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerAndAdmin\ChaletPriceDiscountCodesResource;
use App\Models\ChaletPrice;
use App\Models\ChaletPriceDiscountCode;
use App\Models\UserChaletAdmin;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChaletPriceDiscountCodeController extends Controller
{
    public function chaletPriceDiscountCodes(Request $request)
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
                $chaletPriceActiveDiscountCodes = ChaletPriceDiscountCode::where(function ($query) {
                    $query->where([
                        ['end_at', '<=', now()],
                    ])->orWhere([
                        ['end_at', '=', NULL],
                    ]);
                })->whereHas(
                    'chaletPrice.chalet',
                    function ($query) use ($request) {
                        $query->where([
                            ['id', '=', $request->get('chalets_id')],
                        ]);
                    }
                )->with([
                    'chaletPrice.chalet' => function ($query) use ($request) {
                        $query->where([
                            ['id', '=', $request->get('chalets_id')],
                        ]);
                    },
                ])->get();

                $chaletPriceExpiredDiscountCodes = ChaletPriceDiscountCode::where([
                    ['end_at', '>', now()],
                ])->whereHas(
                    'chaletPrice.chalet',
                    function ($query) use ($request) {
                        $query->where([
                            ['id', '=', $request->get('chalets_id')],
                        ]);
                    }
                )->with([
                    'chaletPrice.chalet' => function ($query) use ($request) {
                        $query->where([
                            ['id', '=', $request->get('chalets_id')],
                        ]);
                    },
                ])->get();

                return response()->json([
                    'status' => true,
                    'chalet_price_active_discount_codes' => ChaletPriceDiscountCodesResource::collection($chaletPriceActiveDiscountCodes),
                    'chalet_price_expired_discount_codes' => ChaletPriceDiscountCodesResource::collection($chaletPriceExpiredDiscountCodes),
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

    public function addChaletPriceDiscountCode(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'percent' => 'required|in:5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95',
            'start_at' => 'required|date_format:Y-m-d H:i|before:end_at',
            'end_at' => 'nullable|date_format:Y-m-d H:i|after:start_at'
        ]);

        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {

                $chaletPrice = ChaletPrice::where([
                    ['chalets_id', '=', $request->get('chalets_id')],
                    ['deleted_at', '=', NULL],
                ])->get()->last();

                $chaletPriceDiscountCode = new ChaletPriceDiscountCode();
                $chaletPriceDiscountCode->chalets_id = $request->get('chalets_id');
                $faker = Factory::create();
                $chaletPriceDiscountCode->code = substr($faker->unique()->sentence(), rand(0, 5), 2) . substr($faker->unique()->sentence(), rand(0, 5), 4) . substr($faker->unique()->sentence(), rand(0, 5), 2);
                $chaletPriceDiscountCode->percent = $request->get('percent');
                $chaletPriceDiscountCode->start_at = $request->get('start_at');
                $chaletPriceDiscountCode->end_at = $request->get('end_at');
                $chaletPriceDiscountCode->chalet_prices_id = $chaletPrice->id;

                $isSaved = $chaletPriceDiscountCode->save();

                if ($isSaved) {
                    return response()->json([
                        'status' => true,
                    ], Response::HTTP_OK);
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

    public function editChaletPriceDiscountCode(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'chalet_price_discount_codes_id' => 'required|exists:chalet_price_discount_codes,id',
            'percent' => 'required|in:5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95',
            'start_at' => 'required|date_format:Y-m-d H:i|before:end_at',
            'end_at' => 'nullable|date_format:Y-m-d H:i|after:start_at'
        ]);

        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {

                $chaletPriceDiscountCode = ChaletPriceDiscountCode::where([
                    ['id', '=', $request->get('chalet_price_discount_codes_id')],
                ])->whereHas(
                    'chaletPrice.chalet',
                    function ($query) use ($request) {
                        $query->where([
                            ['id', '=', $request->get('chalets_id')],
                        ]);
                    }
                )->update(collect(request()->only(['percent', 'start_at', 'end_at']))->filter()->all());

                if (!$request->has('end_at')) {
                    ChaletPriceDiscountCode::where([
                        ['id', '=', $request->get('chalet_price_discount_codes_id')],
                    ])->whereHas(
                        'chaletPrice.chalet',
                        function ($query) use ($request) {
                            $query->where([
                                ['id', '=', $request->get('chalets_id')],
                            ]);
                        }
                    )->update(['end_at' => NULL]);
                }

                if ($chaletPriceDiscountCode > 0) {
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

    public function deleteChaletPriceDiscountCode(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'chalet_price_discount_codes_id' => 'required|exists:chalet_price_discount_codes,id',
        ]);

        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {

                $chaletPriceDiscountCode = ChaletPriceDiscountCode::where([
                    ['id', '=', $request->get('chalet_price_discount_codes_id')],
                ])->whereHas(
                    'chaletPrice.chalet',
                    function ($query) use ($request) {
                        $query->where([
                            ['id', '=', $request->get('chalets_id')],
                        ]);
                    }
                )->update(['end_at' => now()]);

                if ($chaletPriceDiscountCode > 0) {
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
