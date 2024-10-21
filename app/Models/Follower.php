<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    /** @use HasFactory<\Database\Factories\FollowerFactory> */
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(user::class, "user_id");
    }

    public function user_suivi()
    {
        return $this->belongsTo(user::class, "user_suivi_id");
    }
}


// class Article extends Model
// {
//     /** @use HasFactory<\Database\Factories\ArticleFactory> */
//     use HasFactory;

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }
//     protected function casts(): array
//     {
//         return [
//             'published_at' => 'datetime',
//         ];
//     }
// }
