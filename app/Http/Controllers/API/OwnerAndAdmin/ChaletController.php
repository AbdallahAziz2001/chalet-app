<?php

namespace App\Http\Controllers\API\OwnerAndAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerAndAdmin\ChaletById\ChaletByIdResource;
use App\Http\Resources\OwnerAndAdmin\ChaletReservations\ChaletReservationResource;
use App\Models\Chalet;
use App\Models\ChaletImage;
use App\Models\ChaletMainFacility;
use App\Models\ChaletMainFacilitySubFacility;
use App\Models\ChaletPolicy;
use App\Models\ChaletPrice;
use App\Models\ChaletReservation;
use App\Models\ChaletTerm;
use App\Models\User;
use App\Models\UserChaletAdmin;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChaletController extends Controller
{
    public function changeChaletInformation(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'name' => 'nullable|string|min:3|max:75',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'location' => 'nullable|string|min:3|max:255',
            'latitude' => 'nullable|numeric|min:-90|max:90|regex:/^[+-]?+(\d{1,2})+\.+(\d{1,8})$/',
            'longitude' => 'nullable|numeric|min:-180|max:180|regex:/^[+-]?+(\d{1,3})+\.+(\d{1,8})$/',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:50',
            'description' => 'nullable|string|min:10|max:255',
            'space' => 'nullable|numeric|between:0,9999.99',
            'terms' => 'nullable|array|min:1',
            'terms.*' => 'nullable|string|distinct|min:3|max:255',
            'policies' => 'nullable|array|min:1',
            'policies.*' => 'nullable|string|distinct|min:3|max:255',
        ]);

        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {
                try {
                    DB::beginTransaction();
                    Chalet::where('id', '=', $request->get('chalets_id'))->update(collect(request()->only(['name', 'location', 'latitude', 'longitude', 'country', 'city', 'description', 'space']))->filter()->all());
                    if ($request->hasFile('logo')) {
                        $chalet = Chalet::where('id', '=', $request->get('chalets_id'))->first();
                        $logo = $request->file('logo');
                        $logoName = time() . '_' . str_replace(" ", "_", $chalet->name) . '.' . $logo->getClientOriginalExtension();
                        $request->file('logo')->storePubliclyAs('chalets/logos', $logoName, ['disk' => 'public']);
                        Chalet::where('id', '=', $request->get('chalets_id'))->update(['logo' => $logoName]);
                    } else {
                        Chalet::where('id', '=', $request->get('chalets_id'))->update(['logo' => 'logo.png']);
                    }
                    if ($request->has('terms')) {
                        ChaletTerm::where('chalets_id', '=', $request->get('chalets_id'))->delete();
                        foreach ($request->get('terms') as $value) {
                            $chaletTerm = new ChaletTerm();
                            $chaletTerm->chalets_id = $request->get('chalets_id');
                            $chaletTerm->term = $value;
                            $chaletTerm->save();
                        }
                    }
                    if ($request->has('policies')) {
                        ChaletPolicy::where('chalets_id', '=', $request->get('chalets_id'))->delete();
                        foreach ($request->get('policies') as $value) {
                            $chaletPolicy = new ChaletPolicy();
                            $chaletPolicy->chalets_id = $request->get('chalets_id');
                            $chaletPolicy->policy = $value;
                            $chaletPolicy->save();
                        }
                    }
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

    public function changeChaletImages(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'images' => 'required|array|min:1',
            'images.*' => 'required|array|min:1',
            'images.*.order' => 'required|integer|min:1|max:15',
            'images.*.image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {
                try {
                    DB::beginTransaction();
                    $chalet = Chalet::where('id', '=', $request->get('chalets_id'))->first();
                    ChaletImage::where('chalets_id', '=', $request->get('chalets_id'))->delete();
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

    public function changeChaletPrices(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
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
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {
                try {
                    DB::beginTransaction();
                    ChaletPrice::where('chalets_id', '=', $request->get('chalets_id'))->delete();
                    $chaletPrice = new ChaletPrice();
                    $chaletPrice->chalets_id = $request->get('chalets_id');
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
                    $chaletPrice->average_price = ($chaletPrice->saturday_am + $chaletPrice->saturday_pm + $chaletPrice->sunday_am + $chaletPrice->sunday_pm + $chaletPrice->monday_am + $chaletPrice->monday_pm + $chaletPrice->tuesday_am + $chaletPrice->tuesday_pm + $chaletPrice->wednesday_am + $chaletPrice->wednesday_pm + $chaletPrice->thursday_am + $chaletPrice->thursday_pm + $chaletPrice->friday_am + $chaletPrice->friday_pm) / 14;
                    $chaletPrice->save();
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

    public function changeChaletFacilities(Request $request)
    {
        $validator = Validator($request->all(), [
            'chalets_id' => 'required|exists:chalets,id',
            'chalet_main_facilities' => 'required|array|min:1',
            'chalet_main_facilities.*.title' => 'required|string|min:3|max:45',
            'chalet_main_facilities.*.chalet_main_facility_sub_facilities' => 'required|array|min:1',
            'chalet_main_facilities.*.chalet_main_facility_sub_facilities.*' => 'required|string|min:3|max:75',
        ]);

        if (!$validator->fails()) {
            $user = $request->user('sanctum');
            $userForSetAttributeChaletAdminIsOwner = UserChaletAdmin::where([
                ['users_id', '=', $user->id],
                ['chalets_id', '=', $request->get('chalets_id')],
            ])->first();

            if ($userForSetAttributeChaletAdminIsOwner != null) {
                try {
                    DB::beginTransaction();
                    $chalet = Chalet::where('id', '=', $request->get('chalets_id'))->first();
                    ChaletMainFacility::where('chalets_id', '=', $request->get('chalets_id'))->delete();
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

    public function chaletViewer(Request $request)
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
                //
                $chalet = Chalet::where([
                    ['id', '=', $request->get('chalets_id')],
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
                    'chaletReservations' => function ($query) use ($request) {
                        $query->whereBetween(
                            'start_at',
                            [
                                Carbon::parse('Now -75 days')->format('Y-m-d'),
                                Carbon::parse('Now +75 days')->format('Y-m-d')
                            ]
                        )->where(function ($query) use ($request) {
                            $query->where([
                                ['chalets_id', '=', $request->get('chalets_id')],
                                ['status', '=', 'Accepted'],
                            ])->orWhere([
                                ['chalets_id', '=', $request->get('chalets_id')],
                                ['status', '=', 'Completed'],
                            ]);
                        });
                    },
                ])->first();
                return response()->json([
                    'status' => true,
                    'chalet' => ChaletByIdResource::make($chalet),
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'chalet_reservations' => 'User Does Admin in This Chalet',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function chaletReservations(Request $request)
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
                $chaletReservations = ChaletReservation::whereBetween(
                    'start_at',
                    [
                        Carbon::parse('Now -75 days')->format('Y-m-d'),
                        Carbon::parse('Now +75 days')->format('Y-m-d')
                    ]
                )->where(function ($query) use ($request) {
                    $query->where([
                        ['chalets_id', '=', $request->get('chalets_id')],
                        ['status', '=', 'Accepted'],
                    ])->orWhere([
                        ['chalets_id', '=', $request->get('chalets_id')],
                        ['status', '=', 'Completed'],
                    ]);
                })->with([
                    'chaletReservationObject',
                ])->get();

                for ($index = 0; $index < count($chaletReservations); $index++) {
                    if ($chaletReservations[$index]['object_type'] == 'App\\Models\\ChaletAutomaticReservation') {
                        $userForSetAttribute = User::where([
                            ['id', '=', $chaletReservations[$index]['object']['users_id']],
                        ])->first();
                        $chaletReservations[$index]['object']->setAttribute('user', $userForSetAttribute);
                    }
                }

                return response()->json([
                    'status' => true,
                    'chalet_reservations' => ChaletReservationResource::collection($chaletReservations),
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'chalet_reservations' => 'User Does Admin in This Chalet',
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
