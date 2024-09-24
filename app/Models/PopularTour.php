<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularTour extends Model
{
    use HasFactory;

    protected $fillable = ['destination_id', 'package_name', 'duration', 'price', 'inclusion', 'package_image'];

    // A PopularTour belongs to a Destination
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // A PopularTour has many Packages
    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    // A PopularTour has many HotelTypes
    public function hotelTypes()
    {
        return $this->hasMany(HotelType::class);
    }
}
