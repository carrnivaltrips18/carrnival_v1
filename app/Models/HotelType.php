<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelType extends Model
{
    use HasFactory;
    protected $fillable = ['tour_id', 'type', 'price'];

    // A HotelType belongs to a PopularTour
    public function popularTour()
    {
        return $this->belongsTo(PopularTour::class, 'tour_id');
    }
}
