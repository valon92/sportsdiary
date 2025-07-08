<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'thumbnail_url',
        'likes',
        'username',
    ];

    // Optionally, if you later add a comments table for videos:
    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }
}
