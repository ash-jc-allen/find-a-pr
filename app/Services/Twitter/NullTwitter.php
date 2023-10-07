<?php

declare(strict_types=1);

namespace App\Services\Twitter;

readonly class NullTwitter implements TwitterInterface
{
    public function tweet(string $status): ?array
    {
        return null;
    }
}
