<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// use Faker\Generator as Faker;
use App\Models\Destination;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city, // Random city name for destination
            'title' => $this->faker->sentence, // Random title for the destination
            'banner' => $this->faker->imageUrl(640, 480, 'destinations', true), // Fake image URL for the banner
            'long_description' => $this->faker->paragraphs(3, true), // A longer text description for the destination
            'meta_title' => $this->faker->sentence, // Meta title for SEO
            'meta_content' => $this->faker->text(150), // Meta description for SEO
        ];
    }
}
