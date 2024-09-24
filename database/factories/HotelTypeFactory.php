<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HotelType>
 */
class HotelTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tour_id' => PopularTour::inRandomOrder()->first()->id,
            'type' => $faker->randomElement(['Standard', 'Deluxe', 'Suite']),
            'price' => $faker->randomFloat(2, 50, 500),
        ];
    }
}
