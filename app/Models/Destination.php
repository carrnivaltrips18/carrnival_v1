<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'banner', 'long_description', 'meta_title', 'meta_content'];

    // One Destination can have many Popular Tours
    public function popularTours()
    {
        return $this->hasMany(PopularTour::class);
    }
}
