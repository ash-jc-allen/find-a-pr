<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\IpBlockedException;
use Illuminate\Support\Facades\Cache;
use Throwable;

final readonly class Firewall
{
    public function isBlocked(string $ip): bool
    {
        return Cache::has($this->cacheKey($ip));
    }

    public function block(string $ip, Throwable $exception): void
    {
        Cache::add($this->cacheKey($ip), true, now()->addMinutes(30));

        report(new IpBlockedException($ip, $exception));
    }

    private function cacheKey(string $ip): string
    {
        return 'firewall:blocked:'.hash('sha256', $ip);
    }
}
