<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Activity;
use App\Models\Destination;
use App\Models\PopularTour;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(DestinationSeeder::class);
        $this->call(PopularTourSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(ItinerarySeeder::class);

        // $this->call([
        //     RolesAndPermissionsSeeder::class,
        //     AdminSeeder::class, // Add your AdminSeeder here
            
        //     DestinationSeeder::class,
        //     PopularTourSeeder::class,
        //     ActivitySeeder::class,
        //     PackageSeeder::class,
        //     HotelTypeSeeder::class,
        // ]);
    }
}
