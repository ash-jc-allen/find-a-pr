<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    protected $casts = [
        'twitter_sent_at' => 'datetime',
    ];
}
