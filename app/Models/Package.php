<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['tour_id', 'banner'];

    // A Package belongs to a PopularTour
    public function popularTour()
    {
        return $this->belongsTo(PopularTour::class, 'tour_id');
    }
}
