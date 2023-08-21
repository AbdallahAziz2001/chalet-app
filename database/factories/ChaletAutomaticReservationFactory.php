<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChaletAutomaticReservation>
 */
class ChaletAutomaticReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::select('id')->doesntHave("chaletAutomaticReservations")->get();

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
            'users_id' => $users[rand(0, (count($users) - 1))]->id,
            'chalet_rating_user' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
            'description' => $this->faker->boolean(75) ? $this->faker->sentence() : null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
