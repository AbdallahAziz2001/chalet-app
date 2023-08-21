<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserChaletAdminMessage>
 */
class UserChaletAdminMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::select('id')->get();

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
        while (true) {
            $deletedAt = $this->faker->dateTimeBetween($updatedAt, '+15 days');
            if ($deletedAt->format('H') != '00') {
                $deletedAt = $deletedAt->format('Y-m-d H:i:s');
                break;
            }
        }

        return [
            'users_id' => $users[rand(0, (count($users) - 1))]->id,
            'message' => $this->faker->sentence(7),
            'message_by' => $this->faker->randomElement(['User', 'Admin']),
            'deleted_at' => $this->faker->boolean(25) ? $deletedAt : null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
