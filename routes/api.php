<?php

use App\Http\Controllers\API\Auth\GeneratePasswordController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\UserFcmTokenController;
use App\Http\Controllers\API\Auth\VerifyEmailController;
use App\Http\Controllers\API\Auth\VerifyMobileController;
use App\Http\Controllers\API\OwnerAndAdmin\ChaletController as OwnerAndAdminChaletController;
use App\Http\Controllers\API\OwnerAndAdmin\ChaletPriceDiscountCodeController;
use App\Http\Controllers\API\OwnerAndAdmin\ChaletReservationNotificationController;
use App\Http\Controllers\API\User\ChaletController as UserChaletController;
use App\Http\Controllers\API\User\UserBalanceDetailController;
use App\Http\Controllers\API\OwnerAndAdmin\UserChaletAdminController;
use App\Http\Controllers\API\OwnerAndAdmin\UserChaletAdminMessageController as OwnerAndAdminUserChaletAdminMessageController;
use App\Http\Controllers\API\User\UserChaletAdminMessageController as UserUserChaletAdminMessageController;
use App\Http\Controllers\API\User\UserChaletStatusController;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    // Login & Register
    Route::post('login', [LoginController::class, 'login'])->name('api.login');
    Route::post('register', [RegisterController::class, 'register'])->name('api.register');
    // Verify Mobile
    Route::get('verify_mobile_notify_code', [VerifyMobileController::class, 'verifyMobileNotifyCode']);
    Route::post('verify_mobile_check_notify_code', [VerifyMobileController::class, 'verifyMobileCheckNotifyCode']);
    // Generate Password
    Route::post('generate_password', [GeneratePasswordController::class, 'generatePassword']);
});

Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    // Logout
    Route::get('logout', [LogoutController::class, 'logout'])->name('api.logout');
    // FCM Token
    Route::get('user_fcm_token', [UserFcmTokenController::class, 'userFcmToken']);
    Route::post('change_user_fcm_token', [UserFcmTokenController::class, 'changeUserFcmToken']);
    // Send Verify Email
    Route::get('send_email_verify', [VerifyEmailController::class, 'sendVerifyEmail']);
});

Route::prefix('/user')->middleware('auth:sanctum')->group(function () {
    // UserChaletStatus
    Route::get('user_chalet_favorite_status', [UserChaletStatusController::class, 'userChaletFavoriteStatus']);
    Route::post('user_chalet_favorite_status', [UserChaletStatusController::class, 'addUserChaletFavoriteStatus']);
    Route::delete('user_chalet_favorite_status', [UserChaletStatusController::class, 'deleteUserChaletFavoriteStatus']);
    Route::get('user_chalet_block_status', [UserChaletStatusController::class, 'userChaletBlockStatus']);
    Route::post('user_chalet_block_status', [UserChaletStatusController::class, 'addUserChaletBlockStatus']);
    Route::delete('user_chalet_block_status', [UserChaletStatusController::class, 'deleteUserChaletBlockStatus']);
    // Chalet
    Route::post('add_chalet', [UserChaletController::class, 'addChalet']);
    Route::get('researched_chalets_countries', [UserChaletController::class, 'researchedChaletsCountries']);
    Route::get('researched_chalets_cities', [UserChaletController::class, 'researchedChaletsCities']);
    Route::get('researched_chalets', [UserChaletController::class, 'researchedChalets']);
    Route::get('chalets_home_page', [UserChaletController::class, 'chaletsHomePage']);
    Route::get('chalet_by_id', [UserChaletController::class, 'chaletById']);
    Route::get('chalets_i_admin', [UserChaletController::class, 'chaletsIAdmin']);
    Route::post('reserve_chalet', [UserChaletController::class, 'reserveChalet']);
    Route::get('check_discount_code', [UserChaletController::class, 'checkDiscountCode']);
    // UserReservations
    Route::get('user_reservations', [UserController::class, 'userReservations']);
    // User Profile
    Route::get('user_profile_details', [UserController::class, 'userProfileDetails']);
    Route::post('user_profile_change_first_name', [UserController::class, 'userProfileChangeFirstName']);
    Route::post('user_profile_change_last_name', [UserController::class, 'userProfileChangeLastName']);
    Route::post('user_profile_change_username', [UserController::class, 'userProfileChangeUsername']);
    Route::post('user_profile_change_email', [UserController::class, 'userProfileChangeEmail']);
    Route::post('user_profile_change_mobile', [UserController::class, 'userProfileChangeMobile']);
    Route::post('user_profile_change_password', [UserController::class, 'userProfileChangePassword']);
    Route::post('user_profile_change_gender', [UserController::class, 'userProfileChangeGender']);
    Route::post('user_profile_change_birthday', [UserController::class, 'userProfileChangeBirthday']);
    Route::post('user_profile_change_picture', [UserController::class, 'userProfileChangePicture']);
    // UserBalanceDetail
    Route::get('user_balance_details', [UserBalanceDetailController::class, 'userBalanceDetails']);
    Route::post('user_balance_details', [UserBalanceDetailController::class, 'addUserBalanceDetails']);
    // Messages
    Route::get('all_chalets_have_messages', [UserUserChaletAdminMessageController::class, 'allChaletsHaveMessages']);
    Route::get('all_messages', [UserUserChaletAdminMessageController::class, 'allMessages']);
    Route::post('send_message', [UserUserChaletAdminMessageController::class, 'sendMessage']);
    Route::delete('delete_message', [UserUserChaletAdminMessageController::class, 'deleteMessage']);
});

Route::prefix('/owner_and_admin')->middleware('auth:sanctum')->group(function () {
    // UserChaletAdmin
    Route::get('user_chalet_admins', [UserChaletAdminController::class, 'userChaletAdmins']);
    Route::post('user_chalet_admins', [UserChaletAdminController::class, 'addUserChaletAdmins']);
    Route::delete('user_chalet_admins', [UserChaletAdminController::class, 'deleteUserChaletAdmins']);
    // Chalet
    Route::post('change_chalet_information', [OwnerAndAdminChaletController::class, 'changeChaletInformation']);
    Route::post('change_chalet_images', [OwnerAndAdminChaletController::class, 'changeChaletImages']);
    Route::post('change_chalet_prices', [OwnerAndAdminChaletController::class, 'changeChaletPrices']);
    Route::post('change_chalet_facilities', [OwnerAndAdminChaletController::class, 'changeChaletFacilities']);
    Route::get('chalet_viewer', [OwnerAndAdminChaletController::class, 'chaletViewer']);
    // ChaletReservationNotification
    Route::get('chalet_reservation_notifications', [ChaletReservationNotificationController::class, 'chaletReservationNotifications']);
    Route::post('chalet_reservation_change_status', [ChaletReservationNotificationController::class, 'chaletReservationChangeStatus']);
    //ChaletPriceDiscountCode
    Route::get('chalet_price_discount_codes', [ChaletPriceDiscountCodeController::class, 'chaletPriceDiscountCodes']);
    Route::post('add_chalet_price_discount_codes', [ChaletPriceDiscountCodeController::class, 'addChaletPriceDiscountCode']);
    Route::post('change_chalet_price_discount_codes', [ChaletPriceDiscountCodeController::class, 'editChaletPriceDiscountCode']);
    Route::delete('chalet_price_discount_codes', [ChaletPriceDiscountCodeController::class, 'deleteChaletPriceDiscountCode']);
    // ChaletReservations
    Route::get('chalet_reservations', [OwnerAndAdminChaletController::class, 'chaletReservations']);
    // Messages
    Route::get('all_users_have_messages', [OwnerAndAdminUserChaletAdminMessageController::class, 'allUsersHaveMessages']);
    Route::get('all_messages', [OwnerAndAdminUserChaletAdminMessageController::class, 'allMessages']);
    Route::post('send_message', [OwnerAndAdminUserChaletAdminMessageController::class, 'sendMessage']);
    Route::delete('delete_message', [OwnerAndAdminUserChaletAdminMessageController::class, 'deleteMessage']);
});
