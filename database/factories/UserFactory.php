<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        while (true) {
            $date = $this->faker->dateTimeBetween('-5 years', 'now');
            if ($date->format('H') != '00') {
                $date = $date->format('Y-m-d H:i:s');
                break;
            }
        }
        while (true) {
            $birthday = $this->faker->dateTimeBetween('-38 years', '-18 years');
            if ($birthday->format('H') != '00') {
                $birthday = $birthday->format('Y-m-d H:i:s');
                break;
            }
        }
        while (true) {
            $createdAt = $this->faker->dateTimeBetween('-5 years', '-10 days');
            if ($createdAt->format('H') != '00') {
                $createdAt = $createdAt->format('Y-m-d H:i:s');
                break;
            }
        }
        while (true) {
            $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');
            if ($updatedAt->format('H') != '00') {
                $updatedAt = $updatedAt->format('Y-m-d H:i:s');
                break;
            }
        }

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->boolean(75) ? $this->faker->unique()->email() : null,
            'email_verified_at' => $this->faker->boolean(75) ? $date : null,
            'mobile' => $this->faker->unique()->phoneNumber(),
            'password' => Hash::make('User123!'),
            'gender' => $this->faker->boolean(75) ? $this->faker->randomElement(['Male', 'Female']) : null,
            'birthday' => $this->faker->boolean(75) ? $birthday : null,
            'balance' => 0,
            'account_picture' => 'user_profile.png',
            'fcm_token' => substr($this->faker->unique()->sentence(), 0, 60),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
