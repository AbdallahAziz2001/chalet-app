<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChaletImage>
 */
class ChaletImageFactory extends Factory
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
            'image' => $this->faker->randomElement([
                'chalet_images_1.png',
                'chalet_images_2.png',
                'chalet_images_3.png',
                'chalet_images_4.png',
                'chalet_images_5.png',
                'chalet_images_6.png',
                'chalet_images_7.png',
                'chalet_images_8.png',
                'chalet_images_9.png',
                'chalet_images_10.png',
                'chalet_images_11.png',
                'chalet_images_12.png',
                'chalet_images_13.png',
                'chalet_images_14.png',
                'chalet_images_15.png',
                'chalet_images_16.png',
                'chalet_images_17.png',
                'chalet_images_18.png',
                'chalet_images_19.png',
                'chalet_images_20.png',
                'chalet_images_21.png',
                'chalet_images_22.png',
                'chalet_images_23.png',
                'chalet_images_24.png',
                'chalet_images_25.png',
            ]),
            'order' => rand(10000, 30000),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
