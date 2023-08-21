<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChaletManualReservation>
 */
class ChaletManualReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

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
            'national_identification_number' => $this->faker->randomNumber(8, true),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'mobile' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'birthday' => $this->faker->boolean(75) ? $this->faker->date() : null,
            'description' => $this->faker->boolean(75) ? $this->faker->sentence() : null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
