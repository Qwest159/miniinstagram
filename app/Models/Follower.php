<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    // RELATION
    use HasFactory;
    public function follower()
    {
        return $this->belongsTo(User::class, "follower_id");
    }

    public function followed()
    {
        return $this->belongsTo(User::class, "followed_id");
    }
}
