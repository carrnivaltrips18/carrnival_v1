<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Itinerary; // Ensure to import the Itinerary model
use Faker\Factory as Faker;

class ItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        for ($i = 1; $i <= 10; $i++) {
            Itinerary::create([
                'tour_id' => rand(1, 10), // Random package_id from popular_tours
                'day_no' => $i,
                'title' => $faker->sentence,
                'location' => $faker->city,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
