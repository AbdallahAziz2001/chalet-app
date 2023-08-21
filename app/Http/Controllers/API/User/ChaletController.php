<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Chalets\ChaletById\ChaletByIdResource;
use App\Http\Resources\User\Chalets\ChaletById\RandomChaletsResource as ChaletByIdRandomChaletsResource;
use App\Http\Resources\User\Chalets\ChaletsHomePage\RandomChaletsHaveDiscountResource;
use App\Http\Resources\User\Chalets\ChaletsHomePage\RandomChaletsResource;
use App\Http\Resources\User\Chalets\ChaletsIAdminResource;
use App\Http\Resources\User\Chalets\ResearchedChaletsResource;
use App\Models\Chalet;
use App\Models\ChaletAutomaticReservation;
use App\Models\ChaletImage;
use App\Models\ChaletMainFacility;
use App\Models\ChaletMainFacilitySubFacility;
use App\Models\ChaletPolicy;
use App\Models\ChaletPrice;
use App\Models\ChaletPriceDiscountCode;
use App\Models\ChaletReservation;
use App\Models\ChaletTerm;
use App\Models\UserBalanceDetail;
use App\Models\UserChaletAdmin;
use App\Models\UserChaletStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChaletController extends Controller
{
    public function addChalet(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:75',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'location' => 'required|string|min:3|max:255',
            'latitude' => 'required|numeric|min:-90|max:90|regex:/^[+-]?+(\d{1,2})+\.+(\d{1,8})$/',
            'longitude' => 'required|numeric|min:-180|max:180|regex:/^[+-]?+(\d{1,3})+\.+(\d{1,8})$/',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:50',
            'description' => 'required|string|min:10|max:255',
            'space' => 'required|numeric|between:0,9999.99',
            'images' => 'required|array|min:1',
            'images.*' => 'required|array|min:1',
            'images.*.order' => 'required|integer|min:1|max:15',
            'images.*.image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'chalet_main_facilities' => 'required|array|min:1',
            'chalet_main_facilities.*.title' => 'required|string|min:3|max:45',
            'chalet_main_facilities.*.chalet_main_facility_sub_facilities' => 'required|array|min:1',
            'chalet_main_facilities.*.chalet_main_facility_sub_facilities.*' => 'required|string|min:3|max:75',
            'terms' => 'required|array|min:1',
            'terms.*' => 'required|string|distinct|min:3|max:255',
            'policies' => 'required|array|min:1',
            'policies.*' => 'required|string|distinct|min:3|max:255',
            'prices' => 'required|array|size:14',
            'prices.saturday_am' => 'required|numeric|between:0,999999.99',
            'prices.saturday_pm' => 'required|numeric|between:0,999999.99',
            'prices.sunday_am' => 'required|numeric|between:0,999999.99',
            'prices.sunday_pm' => 'required|numeric|between:0,999999.99',
            'prices.monday_am' => 'required|numeric|between:0,999999.99',
            'prices.monday_pm' => 'required|numeric|between:0,999999.99',
            'prices.tuesday_am' => 'required|numeric|between:0,999999.99',
            'prices.tuesday_pm' => 'required|numeric|between:0,999999.99',
            'prices.wednesday_am' => 'required|numeric|between:0,999999.99',
            'prices.wednesday_pm' => 'required|numeric|between:0,999999.99',
            'prices.thursday_am' => 'required|numeric|between:0,999999.99',
            'prices.thursday_pm' => 'required|numeric|between:0,999999.99',
            'prices.friday_am' => 'required|numeric|between:0,999999.99',
            'prices.friday_pm' => 'required|numeric|between:0,999999.99',
        ]);

        if (!$validator->fails()) {
            try {
                DB::beginTransaction();

                $chalet = new Chalet();
                $chalet->name = $request->get('name');
                if ($request->hasFile('logo')) {
                    $logo = $request->file('logo');
                    $logoName = time() . '_' . str_replace(" ", "_", $chalet->name) . '.' . $logo->getClientOriginalExtension();
                    $request->file('logo')->storePubliclyAs('chalets/logos', $logoName, ['disk' => 'public']);
                    $chalet->logo = $logoName;
                } else {
                    $chalet->logo = 'logo.png';
                }
                $chalet->location = $request->get('location');
                $chalet->latitude = $request->get('latitude');
                $chalet->longitude = $request->get('longitude');
                $chalet->country = $request->get('country');
                $chalet->city = $request->get('city');
                $chalet->description = $request->get('description');
                $chalet->space = $request->get('space');

                $chalet->save();

                for ($i = 1; $i <= count($request->file('images')); $i++) {
                    $chaletImage = new ChaletImage();
                    $chaletImage->chalets_id = $chalet->id;
                    $chaletImage->order = $request->get('images')[$i]['order'];
                    $image = $request->file('images')[$i]['image'];
                    $imageName = time() . '_' . $i . '_' . $user->username . '_' . str_replace(" ", "_", $chalet->name) . '.' . $image->getClientOriginalExtension();
                    $request->file('images.' . $i . '.image')->storePubliclyAs('chalets/images', $imageName, ['disk' => 'public']);
                    $chaletImage->image = $imageName;

                    $chaletImage->save();
                }

                for ($i = 1; $i <= count($request->get('chalet_main_facilities')); $i++) {
                    $chaletMainFacility = new ChaletMainFacility();
                    $chaletMainFacility->chalets_id = $chalet->id;

                    $chaletMainFacility->icon = 'icon.png';

                    $chaletMainFacility->title = $request->get('chalet_main_facilities')[$i]['title'];

                    $chaletMainFacility->save();

                    foreach ($request->get('chalet_main_facilities')[$i]['chalet_main_facility_sub_facilities'] as $value) {
                        $chaletMainFacilitySubFacility = new ChaletMainFacilitySubFacility();
                        $chaletMainFacilitySubFacility->chalet_main_facility_id = $chaletMainFacility->id;
                        $chaletMainFacilitySubFacility->title = $value;

                        $chaletMainFacilitySubFacility->save();
                    }
                }

                foreach ($request->get('terms') as $value) {
                    $chaletTerm = new ChaletTerm();
                    $chaletTerm->chalets_id = $chalet->id;
                    $chaletTerm->term = $value;

                    $chaletTerm->save();
                }

                foreach ($request->get('policies') as $value) {
                    $chaletPolicy = new ChaletPolicy();
                    $chaletPolicy->chalets_id = $chalet->id;
                    $chaletPolicy->policy = $value;

                    $chaletPolicy->save();
                }

                $chaletPrice = new ChaletPrice();
                $chaletPrice->chalets_id = $chalet->id;
                $chaletPrice->saturday_am = $request->get('prices')['saturday_am'];
                $chaletPrice->saturday_pm = $request->get('prices')['saturday_pm'];
                $chaletPrice->sunday_am = $request->get('prices')['sunday_am'];
                $chaletPrice->sunday_pm = $request->get('prices')['sunday_pm'];
                $chaletPrice->monday_am = $request->get('prices')['monday_am'];
                $chaletPrice->monday_pm = $request->get('prices')['monday_pm'];
                $chaletPrice->tuesday_am = $request->get('prices')['tuesday_am'];
                $chaletPrice->tuesday_pm = $request->get('prices')['tuesday_pm'];
                $chaletPrice->wednesday_am = $request->get('prices')['wednesday_am'];
                $chaletPrice->wednesday_pm = $request->get('prices')['wednesday_pm'];
                $chaletPrice->thursday_am = $request->get('prices')['thursday_am'];
                $chaletPrice->thursday_pm = $request->get('prices')['thursday_pm'];
                $chaletPrice->friday_am = $request->get('prices')['friday_am'];
                $chaletPrice->friday_pm = $request->get('prices')['friday_pm'];
                $chaletPrice->average_price = ($chaletPrice->saturday_am + $chaletPrice->saturday_pm + $chaletPrice->sunday_am
                    + $chaletPrice->sunday_pm + $chaletPrice->monday_am + $chaletPrice->monday_pm + $chaletPrice->tuesday_am
                    + $chaletPrice->tuesday_pm + $chaletPrice->wednesday_am + $chaletPrice->wednesday_pm + $chaletPrice->thursday_am
                    + $chaletPrice->thursday_pm + $chaletPrice->friday_am + $chaletPrice->friday_pm) / 14;

                $chaletPrice->save();

                $userChaletAdmin = new UserChaletAdmin();
                $userChaletAdmin->users_id = $user->id;
                $userChaletAdmin->chalets_id = $chalet->id;
                $userChaletAdmin->is_owner = true;

                $userChaletAdmin->save();

                DB::commit();

                return response()->json([
                    'status' => true,
                ], Response::HTTP_OK);
            } catch (Exception $exception) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'You Have Some Error'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function researchedChaletsCountries(Request $request)
    {
        $countries = Chalet::select('country')->groupBy('country')->get();

        return response()->json([
            'status' => true,
            'countries' => $countries,
        ]);
    }

    public function researchedChaletsCities(Request $request)
    {
        $validator = Validator($request->all(), [
            'country' => 'required|string|max:10',
        ]);

        if (!$validator->fails()) {
            $cities = Chalet::select('city')->where([
                ['country', '=', $request->get('country')],
            ])->groupBy('city')->get();

            return response()->json([
                'status' => true,
                'cities' => $cities,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function researchedChalets(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'country' => 'required|string|max:10',
            'cities' => 'required|array|min:1',
            'cities.*' => 'required|string|distinct|max:50',
        ]);

        if (!$validator->fails()) {
            $researchedChalets = Chalet::where([
                ['country', '=', $request->get('country')],
            ])->whereIn(
                'city',
                $request->get('cities'),
            )->whereHas(
                'chaletPrices',
                function ($query) {
                    $query->select('id', 'chalets_id')->where([
                        ['deleted_at', '=', NULL],
                    ]);
                }
            )->with([
                'chaletImages' => function ($query) {
                    $query->select('id', 'chalets_id', 'order', 'image')->orderBy('order');
                },
            ])->withCount([
                'chaletReservations' => function ($query) {
                    $query->where([
                        ['status', '!=', 'Pending'],
                        ['status', '!=', 'Canceled'],
                    ]);
                }
            ])->whereDoesntHave(
                'userChaletStatusUsers',
                function ($query) use ($user) {
                    $query->where([
                        ['users_id', '=', $user->id],
                        ['status', '=', 'Block'],
                    ]);
                }
            )->get();

            return response()->json([
                'status' => true,
                'researched_chalets' => ResearchedChaletsResource::collection($researchedChalets),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function chaletsHomePage(Request $request)
    {
        $user = $request->user('sanctum');

        $randomChaletsHaveDiscount = Chalet::whereHas(
            'chaletPrices',
            function ($query) {
                $query->whereHas(
                    'chaletPriceDiscountCodes',
                    function ($query) {
                        $query->where([
                            ['start_at', '<=', now()],
                            ['end_at', '>=', now()],
                        ])->orWhere([
                            ['start_at', '<=', now()],
                            ['end_at', '=', NULL],
                        ]);
                    },
                );
            },
        )->with([
            'chaletImages' => function ($query) {
                $query->select('id', 'chalets_id', 'order', 'image')->orderBy('order');
            },
            'chaletPrices' => function ($query) {
                $query->whereHas(
                    'chaletPriceDiscountCodes',
                    function ($query) {
                        $query->where([
                            ['start_at', '<=', now()],
                            ['end_at', '>=', now()],
                        ])->orWhere([
                            ['start_at', '<=', now()],
                            ['end_at', '=', NULL],
                        ]);
                    },
                )->with([
                    'chaletPriceDiscountCodes' => function ($query) {
                        $query->where([
                            ['start_at', '<=', now()],
                            ['end_at', '>=', now()],
                        ])->orWhere([
                            ['start_at', '<=', now()],
                            ['end_at', '=', NULL],
                        ]);
                    },
                ]);
            },
        ])->whereDoesntHave(
            'userChaletStatusUsers',
            function ($query) use ($user) {
                $query->where([
                    ['users_id', '=', $user->id],
                    ['status', '=', 'Block'],
                ]);
            }
        )->orderByRaw('RAND()')->take(10)->get();

        $chalets = Chalet::whereDoesntHave(
            'userChaletStatusUsers',
            function ($query) use ($user) {
                $query->where([
                    ['users_id', '=', $user->id],
                    ['status', '=', 'Block'],
                ]);
            }
        )->get();

        $chaletsCountForSearch = $chalets->count();

        $randomChalets = Chalet::with([
            'chaletImages' => function ($query) {
                $query->select('id', 'chalets_id', 'order', 'image')->orderBy('order');
            },
        ])->whereDoesntHave(
            'userChaletStatusUsers',
            function ($query) use ($user) {
                $query->where([
                    ['users_id', '=', $user->id],
                    ['status', '=', 'Block'],
                ]);
            }
        )->orderByRaw('RAND()')->take(10)->get();

        return response()->json([
            'status' => true,
            'random_chalets_have_discount' => RandomChaletsHaveDiscountResource::collection($randomChaletsHaveDiscount),
            'chalets_count_for_search' => (floor($chaletsCountForSearch / 10) * 10),
            'random_chalets' => RandomChaletsResource::collection($randomChalets),
        ]);
    }

    public function chaletById(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'id' => 'required|exists:chalets,id',
        ]);

        if (!$validator->fails()) {
            $chalet = Chalet::where([
                ['id', '=', $request->get('id')],
            ])->with([
                'chaletImages' => function ($query) {
                    $query->select('id', 'chalets_id', 'order', 'image')->orderBy('order');
                },
                'chaletTerms' => function ($query) {
                    $query->select('id', 'chalets_id', 'term');
                },
                'chaletPolicies' => function ($query) {
                    $query->select('id', 'chalets_id', 'policy');
                },
                'chaletPrices' => function ($query) {
                    $query->latest('id')->first();
                },
                'chaletMainFacilities.chaletMainFacilitySubFacilities' => function ($query) {
                },
                'chaletReservations' => function ($query) {
                    $query->whereBetween(
                        'start_at',
                        [
                            Carbon::parse('Now -75 days')->format('Y-m-d'),
                            Carbon::parse('Now +75 days')->format('Y-m-d')
                        ]
                    )->where(function ($query) {
                        $query->where([
                            ['status', '=', 'Accepted'],
                        ])->orWhere([
                            ['status', '=', 'Completed'],
                        ]);
                    });
                },
            ])->whereDoesntHave(
                'userChaletStatusUsers',
                function ($query) use ($user) {
                    $query->where([
                        ['users_id', '=', $user->id],
                        ['status', '=', 'Block'],
                    ]);
                }
            )->first();

            $userChaletStatus = UserChaletStatus::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('id')],
                ['status', '=', 'Favorite'],
            ])->first();

            if ($userChaletStatus != null) {
                $chalet->setAttribute('isFavorite', true);
            } else {
                $chalet->setAttribute('isFavorite', false);
            }


            $randomChalets = Chalet::where([
                ['id', '!=', $chalet->id],
                ['city', '=', $chalet->city],
            ])->with([
                'chaletImages' => function ($query) {
                    $query->select('id', 'chalets_id', 'order', 'image');
                },
            ])->whereDoesntHave(
                'userChaletStatusUsers',
                function ($query) use ($user) {
                    $query->where([
                        ['users_id', '=', $user->id],
                        ['status', '=', 'Block'],
                    ]);
                }
            )->orderByRaw('RAND()')->take(10)->get();

            return response()->json([
                'status' => true,
                'chalet' => ChaletByIdResource::make($chalet),
                'random_chalets' => ChaletByIdRandomChaletsResource::collection($randomChalets),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function chaletsIAdmin(Request $request)
    {
        $user = $request->user('sanctum');

        $chalets = $user->userChaletAdminChalets()->where([
            ['deleted_at', '=', Null],
        ])->get(['chalets_id as id', 'logo', 'name']);

        return response()->json([
            'status' => true,
            'chalets' => ChaletsIAdminResource::collection($chalets),
        ]);
    }

    public function reserveChalet(Request $request)
    {
        $user = $request->user('sanctum');

        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'start_at' => 'required|date_format:Y-m-d',
            'period_start' => 'required|in:Morning,Evening',
            'end_at' => 'required|date_format:Y-m-d',
            'period_end' => 'required|in:Morning,Evening',
            'total_price' => 'required|numeric|between:0,99999999.99',
            'details' => 'required|string|min:3|max:255',
            'chalet_price_discount_codes_id' => 'nullable|exists:chalet_price_discount_codes,id',
        ]);

        if (!$validator->fails()) {
            if ($user->balance >= $request->get('total_price')) {
                $chaletAutomaticReservations = new ChaletAutomaticReservation();
                $chaletAutomaticReservations->users_id = $user->id;

                $chaletAutomaticReservationsIsSaved = $chaletAutomaticReservations->save();

                if ($chaletAutomaticReservationsIsSaved) {
                    $chaletReservations = new ChaletReservation();
                    $chaletReservations->chalets_id = $request->get('chalets_id');
                    $chaletReservations->start_at = $request->get('start_at');
                    $chaletReservations->period_start = $request->get('period_start');
                    $chaletReservations->end_at = $request->get('end_at');
                    $chaletReservations->period_end = $request->get('period_end');
                    $chaletReservations->status = 'Pending';
                    $chaletReservations->price_after_discount = $request->get('total_price');

                    if ($request->has('chalet_price_discount_codes_id')) {
                        $chaletReservations->chalet_price_discount_codes_id = $request->get('chalet_price_discount_codes_id');
                    }

                    $chaletReservations->object_id = $chaletAutomaticReservations->id;
                    $chaletReservations->object_type = 'App\Models\ChaletAutomaticReservation';

                    $chaletReservationsIsSaved = $chaletReservations->save();

                    if ($chaletReservationsIsSaved) {

                        $user->balance = $user->balance - $request->get('total_price');

                        $userBalanceDetails = new UserBalanceDetail();
                        $userBalanceDetails->users_id = $user->id;
                        $userBalanceDetails->balance = $request->get('total_price');

                        if ($request->has('details')) {
                            $userBalanceDetails->details = $request->get('details');
                        }

                        $userBalanceDetails->type = 'Withdraw';

                        $userBalanceDetailsIsSaved = $userBalanceDetails->save();

                        if ($userBalanceDetailsIsSaved) {
                            return response()->json([
                                'status' => true,
                            ], Response::HTTP_OK);
                        } else {
                            $userBalanceDetails->delete();
                            return response()->json([
                                'status' => false,
                                'message' => 'You Have Some Error'
                            ], Response::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $chaletReservations->delete();
                        return response()->json([
                            'status' => false,
                            'message' => 'You Have Some Error'
                        ], Response::HTTP_BAD_REQUEST);
                    }
                } else {
                    $chaletAutomaticReservations->delete();
                    return response()->json([
                        'status' => false,
                        'message' => 'You Have Some Error'
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You Don\'t Have Money'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function checkDiscountCode(Request $request)
    {

        $validator = Validator($request->all(), [
            'code' => 'required|exists:chalet_price_discount_codes,code',
            'chalets_id' => 'required|exists:chalets,id',
        ]);

        if (!$validator->fails()) {

            $chaletPriceDiscountCode = ChaletPriceDiscountCode::whereHas(
                'chaletPrice',
                function ($query) use ($request) {
                    $query->where([
                        ['code', '=', $request->get('code')],
                        ['end_at', '>', now()],
                    ])->orWhere([
                        ['code', '=', $request->get('code')],
                        ['end_at', '=', NULL],
                    ])->whereHas(
                        'chalet',
                        function ($query) use ($request) {
                            $query->where([
                                ['id', '=', $request->get('chalets_id')],
                            ]);
                        }
                    );
                }
            )->select('id', 'chalet_prices_id', 'code', 'percent')->first();

            if ($chaletPriceDiscountCode != null) {
                return response()->json([
                    'status' => true,
                    'chalet_price_discount_code' => $chaletPriceDiscountCode,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Discount Code Does Not Exist for This Chalet',
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
