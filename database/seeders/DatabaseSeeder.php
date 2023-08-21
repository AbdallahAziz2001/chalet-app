<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Chalet;
use App\Models\ChaletAutomaticReservation;
use App\Models\ChaletImage;
use App\Models\ChaletMainFacility;
use App\Models\ChaletMainFacilitySubFacility;
use App\Models\ChaletManualReservation;
use App\Models\ChaletPolicy;
use App\Models\ChaletPrice;
use App\Models\ChaletPriceDiscountCode;
use App\Models\ChaletReservation;
use App\Models\ChaletTerm;
use App\Models\User;
use App\Models\UserBalanceDetail;
use App\Models\UserChaletAdmin;
use App\Models\UserChaletAdminMessage;
use App\Models\UserChaletStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Seeder
        $admin = Admin::create([
            'first_name' => 'Abdallah',
            'last_name' => 'Aziz',
            'username' => 'abdallahaziz2001',
            'account_picture' => 'Abdallah_Aziz.jpg',
            'password' => Hash::make('Admin123!'),
        ]);
        $admin = Admin::create([
            'first_name' => 'Yousef',
            'last_name' => 'Ammar',
            'username' => 'yousefammar2001',
            'account_picture' => 'Yousef_Ammar.jpg',
            'password' => Hash::make('Admin123!'),
        ]);
        $admin = Admin::create([
            'first_name' => 'Anas',
            'last_name' => 'Al-Derfil',
            'username' => 'anasalderfil2001',
            'account_picture' => 'Anas_AlDerfil.jpg',
            'password' => Hash::make('Admin123!'),
        ]);
        $admin = Admin::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Al-Sakani',
            'username' => 'ahmedalsakni2001',
            'account_picture' => 'Ahmed_AlSakani.jpg',
            'password' => Hash::make('Admin123!'),
        ]);

        // User Seeder
        User::factory(2500)->create()
            ->each(function ($user) {
                $user->userBalanceDetails()
                    ->saveMany(UserBalanceDetail::factory(rand(0, rand(5, 15)))->make())
                    ->each(function ($userBalanceDetail) use ($user) {
                        if (rand(0, 2) != 1) {
                            if ($userBalanceDetail->type == 'Deposit' && ($user->balance + $userBalanceDetail->balance) <= 999999.99) {
                                $user->balance = ($user->balance + $userBalanceDetail->balance);
                                $user->save();
                            } elseif ($userBalanceDetail->type == 'Withdraw' && $user->balance >= $userBalanceDetail->balance) {
                                $user->balance = ($user->balance - $userBalanceDetail->balance);
                                $user->save();
                            } else {
                                $userBalanceDetail->delete();
                            }
                        }
                    });
            });

        // Chalet Seeder
        Chalet::factory(250)->create()
            ->each(function ($chalet) {
                $chalet->chaletImages()
                    ->saveMany(ChaletImage::factory(rand(1, 5))->make())
                    ->each(function ($chaletImage) use ($chalet) {
                        $lastChaletImage = ChaletImage::where([
                            ['chalets_id', '=', $chalet->id],
                            ['order', '<', 10000],
                        ])->get()->last();
                        if ($lastChaletImage == null) {
                            $chaletImage->order = 1;
                            $chaletImage->save();
                        } else {
                            $chaletImage->order = $lastChaletImage->order + 1;
                            $chaletImage->save();
                        }
                    });

                $chalet->chaletTerms()
                    ->saveMany(ChaletTerm::factory(rand(1, 10))->make());

                $chalet->chaletPolicies()
                    ->saveMany(ChaletPolicy::factory(rand(1, 10))->make());

                $chalet->chaletMainFacilities()
                    ->saveMany(ChaletMainFacility::factory(rand(1, 5))->make())
                    ->each(function ($chaletMainFacility) {
                        $chaletMainFacility->chaletMainFacilitySubFacilities()
                            ->saveMany(ChaletMainFacilitySubFacility::factory(rand(1, 5))->make());
                    });

                $chalet->chaletPrices()
                    ->saveMany(ChaletPrice::factory(rand(1, rand(3, 5)))->make())
                    ->each(function ($chaletPrice) {
                        if (rand(0, 3) == 1) {
                            $chaletPrice->chaletPriceDiscountCodes()
                                ->saveMany(ChaletPriceDiscountCode::factory(rand(1, 3))->make());
                        }
                    });

                $faker = Factory::create();

                $users = User::select('id')->doesntHave("chaletAutomaticReservations")->get();

                while (true) {
                    $createdAt = $faker->dateTimeBetween('-5 years', '-10 days');
                    if ($createdAt->format('H') != '00') {
                        $createdAt = $createdAt->format('Y-m-d H:i:s');
                        break;
                    }
                }
                while (true) {
                    $updatedAt = $faker->dateTimeBetween($createdAt, 'now');
                    if ($updatedAt->format('H') != '00') {
                        $updatedAt = $updatedAt->format('Y-m-d H:i:s');
                        break;
                    }
                }

                $chalet->userChaletAdmins()
                    ->saveMany(UserChaletAdmin::factory(1)->make([
                        'users_id' => $users[rand(5, 95)]->id,
                        'is_owner' => true,
                        'deleted_at' => null,
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt,
                    ]))->each(function ($userChaletAdmin) {
                        $userChaletAdmin->userChaletAdminMessages()
                            ->saveMany(UserChaletAdminMessage::factory(rand(5, rand(5, 15))));
                    });

                if (rand(0, 2) != 1) {
                    $chalet->userChaletStatuses()
                        ->saveMany(UserChaletStatus::factory(rand(1, rand(3, 5)))->make());
                }

                if (rand(0, 2) != 1) {

                    $chalet->userChaletAdmins()
                        ->saveMany(UserChaletAdmin::factory(rand(1, rand(3, 5)))->make())
                        ->each(function ($userChaletAdmin) {
                            $userChaletAdmin->userChaletAdminMessages()
                                ->saveMany(UserChaletAdminMessage::factory(rand(5, rand(15, 50)))->make());
                        });
                }
            });

        // ChaletReservation
        ChaletAutomaticReservation::factory(20000)->create();
        ChaletManualReservation::factory(10000)->create();
        for ($index = 1; $index <= 30000; $index++) {
            ChaletReservation::factory(1)->create();
            print($index . ' | ');
        }
    }
}
