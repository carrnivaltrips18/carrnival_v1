<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'day_no',
        'title',
        'location',
        'description',
    ];

    public function popularTour()
    {
        return $this->belongsTo(PopularTour::class, 'tour_id');
    }
}
