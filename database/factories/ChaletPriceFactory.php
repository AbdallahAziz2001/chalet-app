<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChaletPrice>
 */
class ChaletPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d H:i:s');

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
            'average_price' => $this->faker->randomFloat(2, 0, 999999.99),
            'saturday_am' => $this->faker->randomFloat(2, 0, 999999.99),
            'saturday_pm' => $this->faker->randomFloat(2, 0, 999999.99),
            'sunday_am' => $this->faker->randomFloat(2, 0, 999999.99),
            'sunday_pm' => $this->faker->randomFloat(2, 0, 999999.99),
            'monday_am' => $this->faker->randomFloat(2, 0, 999999.99),
            'monday_pm' => $this->faker->randomFloat(2, 0, 999999.99),
            'tuesday_am' => $this->faker->randomFloat(2, 0, 999999.99),
            'tuesday_pm' => $this->faker->randomFloat(2, 0, 999999.99),
            'wednesday_am' => $this->faker->randomFloat(2, 0, 999999.99),
            'wednesday_pm' => $this->faker->randomFloat(2, 0, 999999.99),
            'thursday_am' => $this->faker->randomFloat(2, 0, 999999.99),
            'thursday_pm' => $this->faker->randomFloat(2, 0, 999999.99),
            'friday_am' => $this->faker->randomFloat(2, 0, 999999.99),
            'friday_pm' => $this->faker->randomFloat(2, 0, 999999.99),
            'deleted_at' => $deletedAt,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
