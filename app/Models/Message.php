<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Assuming you have a User model

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id'];

    // Each message belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
