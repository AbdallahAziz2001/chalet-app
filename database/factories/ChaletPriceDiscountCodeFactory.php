<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChaletPriceDiscountCode>
 */
class ChaletPriceDiscountCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        while (true) {
            $startAtDate = $this->faker->dateTimeBetween('-5 years', 'now');
            if ($startAtDate->format('H') != '00') {
                $startAtDate = $startAtDate->format('Y-m-d H:i:s');
                break;
            }
        }
        while (true) {
            $endAtDate = $this->faker->dateTimeBetween($startAtDate, '+1 month');
            if ($endAtDate->format('H') != '00') {
                $endAtDate = $endAtDate->format('Y-m-d H:i:s');
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
            'code' => substr($this->faker->unique()->sentence(), rand(0, 5), 2) . substr($this->faker->unique()->sentence(), rand(0, 5), 4) . substr($this->faker->unique()->sentence(), rand(0, 5), 2),
            'percent' => $this->faker->randomElement(['5', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60', '65', '70', '75', '80', '85', '90', '95']),
            'start_at' => $startAtDate,
            'end_at' => $this->faker->boolean(75) ? $endAtDate : null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
