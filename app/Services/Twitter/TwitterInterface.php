<?php

declare(strict_types=1);

namespace App\Services\Twitter;

interface TwitterInterface
{
    public function tweet(string $status): ?array;
}
