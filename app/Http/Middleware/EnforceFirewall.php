<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Firewall;
use Closure;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class EnforceFirewall
{
    public function __construct(
        #[Config('features.enable_firewall')] private bool $enabled,
        private Firewall $firewall,
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (
            $this->enabled
            && $request->ip() !== null
            && $this->firewall->isBlocked($request->ip())
        ) {
            abort(404);
        }

        return $next($request);
    }
}
