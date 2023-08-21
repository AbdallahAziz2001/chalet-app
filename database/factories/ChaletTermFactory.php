<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChaletTerm>
 */
class ChaletTermFactory extends Factory
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
            'term' => $this->faker->unique()->sentence(),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
