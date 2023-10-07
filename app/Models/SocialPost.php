<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class SocialPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id',
        'issue_repo',
        'issue_number',
        'twitter_sent_at',
        'tweet_id',
    ];

    protected $casts = [
        'twitter_sent_at' => 'datetime',
    ];

    public function tweetWasSent(): bool
    {
        return ! is_null($this->twitter_sent_at);
    }
}
