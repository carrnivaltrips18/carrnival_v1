<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyDetail;

class CompanyDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyDetail::create([
            'name' => 'Carnival Trips',
            'email' => 'info@carrnivaltrips.com',
            'website' => 'https://carrnivaltrips.com/',
            'fav_icon' => null,  // Set default null values for new fields
            'phone' => '91xxxxxxxx',
            'address' => 'Dimand Plaza Nagar bazar Dum Dum',
            'description' => null,
            'facebook' => 'www.facebook.com',
            'twitter' => 'www.twitter.com',
            'instagram' => 'www.instagram.com',
            'linkedin'=> 'www.linkedin.com',
        ]);
    }
}
