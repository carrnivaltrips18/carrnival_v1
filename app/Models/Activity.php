<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['destination_id', 'tour_id', 'title', 'image', 'description', 'price'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function popularTour()
    {
        return $this->belongsTo(PopularTour::class, 'tour_id');
    }
}
