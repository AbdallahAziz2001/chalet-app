<?php

namespace Database\Factories;

use App\Models\Chalet;
use App\Models\ChaletAutomaticReservation;
use App\Models\ChaletManualReservation;
use App\Models\ChaletPriceDiscountCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChaletReservation>
 */
class ChaletReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chalets = Chalet::select('id')->get();
        $chaletId = $chalets[rand(0, (count($chalets) - 1))]->id;
        $chaletAutomaticReservations = ChaletAutomaticReservation::select('id')->doesntHave("chaletReservation")->get();
        $chaletManualReservations = ChaletManualReservation::select('id')->doesntHave("chaletReservation")->get();
        $chaletPriceDiscountCodes = ChaletPriceDiscountCode::select('id')->whereHas('chaletPrice', function ($query) use ($chaletId) {
            $query->where('chalets_id', '=', $chaletId);
        })->get();

        while (true) {
            $startAtDate = $this->faker->dateTimeBetween('-100 days', '+100 days');
            if ($startAtDate->format('H') != '00') {
                $startAtDate = $startAtDate->format('Y-m-d H:i:s');
                break;
            }
        }
        while (true) {
            $endAtDate = $this->faker->dateTimeBetween($startAtDate, '+100 days');
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

        $randomBoolean = $this->faker->boolean();

        return [
            'chalets_id' => $chaletId,
            'object_id' => $randomBoolean && (count($chaletManualReservations) > 0) ? $chaletManualReservations[rand(0, (count($chaletManualReservations) - 1))]->id : ((count($chaletAutomaticReservations) > 0) ? $chaletAutomaticReservations[rand(0, (count($chaletAutomaticReservations) - 1))]->id : $chaletManualReservations[rand(0, (count($chaletManualReservations) - 1))]->id),
            'object_type' => $randomBoolean && (count($chaletManualReservations) > 0) ? ChaletManualReservation::class : ((count($chaletAutomaticReservations) > 0) ? ChaletAutomaticReservation::class : ChaletManualReservation::class),
            'chalet_price_discount_codes_id' => $this->faker->boolean(25) && (count($chaletPriceDiscountCodes) > 0) ? $chaletPriceDiscountCodes[rand(0, (count($chaletPriceDiscountCodes) - 1))]->id : null,
            'start_at' => $startAtDate,
            'end_at' => $endAtDate,
            'period_start' => $this->faker->randomElement(['Morning', 'Evening']),
            'period_end' => $this->faker->randomElement(['Morning', 'Evening']),
            'status' => $this->faker->randomElement(['Pending', 'Accepted', 'Canceled', 'Completed']),
            'price_after_discount' => $this->faker->randomFloat(2, 0, 999999.99),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
