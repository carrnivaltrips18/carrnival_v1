<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Activity;
use App\Models\Destination;
use App\Models\PopularTour;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'destination_id' => Destination::factory(),
            'tour_id' => PopularTour::factory(),
            'title' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(640, 480, 'activities', true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 50, 1000),
        ];
    }
}
