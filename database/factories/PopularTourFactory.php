<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// use Faker\Generator as Faker;
use App\Models\Destination;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PopularTour>
 */
class PopularTourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'destination_id' => Destination::inRandomOrder()->first()->id, // Random destination
            'package_name' => $this->faker->sentence(3), // Random package name
            'duration' => $this->faker->numberBetween(3, 15), // Duration in days
            'price' => $this->faker->randomFloat(2, 100, 1000), // Random price between 100 and 1000
            'inclusion' => $this->faker->paragraph, // Random inclusion description
            'package_image' => $this->faker->imageUrl(800, 600, 'package'), // Random image for package
        ];
    }
}
