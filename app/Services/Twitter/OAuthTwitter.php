<?php

declare(strict_types=1);

namespace App\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;

final readonly class OAuthTwitter implements TwitterInterface
{
    public function __construct(
        protected TwitterOAuth $twitter,
    ) {
        //
    }

    public function tweet(string $status): ?array
    {
        return (array) $this->twitter->post('tweets', ['text' => $status], ['jsonPayload' => true]);
    }
}
