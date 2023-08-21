<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ChaletController;
use App\Http\Controllers\Dashboard\DashboardhController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('dashboard/')->middleware('guest:admin')->group(function () {
    Route::get('{guard}/login', [LoginController::class, 'showLogin'])->name('dashboard.login');
    Route::post('admin/login', [LoginController::class, 'login']);
});

Route::prefix('dashboard/')->middleware('auth:admin')->group(function () {
    Route::get('home', [DashboardhController::class, 'showDashboard'])->name('dashboard.home');
    Route::resource('admins', AdminController::class);
    Route::resource('users', UserController::class);
    Route::resource('chalets', ChaletController::class);

    Route::view('our-team', 'dashboard.our-team')->name('dashboard.our-team');

    Route::get('change-password', [ChangePasswordController::class, 'showChangePassword'])->name('dashboard.change-password');
    Route::post('change-password', [ChangePasswordController::class, 'changePassword']);

    Route::get('logout', [LogoutController::class, 'logout'])->name('dashboard.logout');
});

// Email Verify
Route::get(
    '/verify_email/{email_verifications_id}/users_id/{users_id}/hash/{hash}/expiration/{expiration}',
    [VerifyEmailController::class, 'emailVerifiedView']
)->name('email_verified')->middleware('signed');

use Illuminate\Support\Facades\DB;
// Edit DataBase
Route::get(
    '/restart_database',
    function () {
        // Delete All Data
        DB::statement('DELETE FROM `password_reset_tokens`;');
        DB::statement('DELETE FROM `failed_jobs`;');
        DB::statement('DELETE FROM `personal_access_tokens`;');
        DB::statement('DELETE FROM `admins`;');
        DB::statement('DELETE FROM `users`;');
        DB::statement('DELETE FROM `chalets`;');
        DB::statement('DELETE FROM `user_balance_details`;');
        DB::statement('DELETE FROM `chalet_images`;');
        DB::statement('DELETE FROM `chalet_policies`;');
        DB::statement('DELETE FROM `chalet_prices`;');
        DB::statement('DELETE FROM `chalet_terms`;');
        DB::statement('DELETE FROM `chalet_main_facilities`;');
        DB::statement('DELETE FROM `chalet_main_facility_sub_facilities`;');
        DB::statement('DELETE FROM `chalet_price_discount_codes`;');
        DB::statement('DELETE FROM `user_chalet_statuses`;');
        DB::statement('DELETE FROM `user_chalet_admins`;');
        DB::statement('DELETE FROM `user_chalet_admin_messages`;');
        DB::statement('DELETE FROM `chalet_automatic_reservations`;');
        DB::statement('DELETE FROM `chalet_manual_reservations`;');
        DB::statement('DELETE FROM `chalet_reservations`;');

        // Restart Auto Increment
        DB::statement('ALTER TABLE `password_reset_tokens` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `failed_jobs` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `personal_access_tokens` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `admins` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `users` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalets` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `user_balance_details` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_images` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_policies` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_prices` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_terms` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_main_facilities` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_main_facility_sub_facilities` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_price_discount_codes` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `user_chalet_statuses` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `user_chalet_admins` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `user_chalet_admin_messages` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_automatic_reservations` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_manual_reservations` AUTO_INCREMENT  = 1;');
        DB::statement('ALTER TABLE `chalet_reservations` AUTO_INCREMENT  = 1;');

        // insert Data
        DB::unprepared(file_get_contents(public_path('sql\password_reset_tokens.sql')));
        DB::unprepared(file_get_contents(public_path('sql\failed_jobs.sql')));
        DB::unprepared(file_get_contents(public_path('sql\personal_access_tokens.sql')));
        DB::unprepared(file_get_contents(public_path('sql\admins.sql')));
        DB::unprepared(file_get_contents(public_path('sql\users.sql')));
        DB::unprepared(file_get_contents(public_path('sql\email_verifications.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalets.sql')));
        DB::unprepared(file_get_contents(public_path('sql\user_balance_details_1.sql')));
        DB::unprepared(file_get_contents(public_path('sql\user_balance_details_2.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_images.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_policies.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_prices.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_terms.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_main_facilities.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_main_facility_sub_facilities.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_price_discount_codes.sql')));
        DB::unprepared(file_get_contents(public_path('sql\user_chalet_statuses.sql')));
        DB::unprepared(file_get_contents(public_path('sql\user_chalet_admins.sql')));
        DB::unprepared(file_get_contents(public_path('sql\user_chalet_admin_messages_1.sql')));
        DB::unprepared(file_get_contents(public_path('sql\user_chalet_admin_messages_2.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_automatic_reservations_1.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_automatic_reservations_2.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_automatic_reservations_3.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_automatic_reservations_4.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_manual_reservations_1.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_manual_reservations_2.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_reservations_1.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_reservations_2.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_reservations_3.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_reservations_4.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_reservations_5.sql')));
        DB::unprepared(file_get_contents(public_path('sql\chalet_reservations_6.sql')));

        echo ('SQL Import Done');
    }
);
