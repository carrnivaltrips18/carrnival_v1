<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
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
            'destination_id' => Destination::inRandomOrder()->first()->id,
            'package_name' => $faker->sentence(3),
            'duration' => $faker->numberBetween(3, 15),
            'price' => $faker->randomFloat(2, 100, 1000),
            'inclusion' => $faker->paragraph,
            'package_image' => $faker->imageUrl(800, 600, 'package'),
        ];
    }
}
