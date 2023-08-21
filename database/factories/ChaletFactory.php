<?php

namespace Database\Factories;

use App\Models\Chalet;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChaletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $coordinates = $this->faker->localCoordinates();

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
            'name' => $this->faker->name(),
            'logo' => 'logo.png',
            'location' => $this->faker->streetAddress(),
            'latitude' => $coordinates["latitude"],
            'longitude' => $coordinates["longitude"],
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'description' => $this->faker->sentence(),
            'space' => $this->faker->randomFloat(2, 50, 9999.99),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
