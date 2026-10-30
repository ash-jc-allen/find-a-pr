<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class IpCheckController extends Controller
{
    public function __invoke(
        Request $request,
        #[Config('firewall.ip_check_secret')] ?string $secret,
    ): JsonResponse {
        $this->verifySecret($request, $secret);

        return response()->json([
            'ip' => $request->ip(),
            'ips' => $request->ips(),
            'remote_addr' => $request->server('REMOTE_ADDR'),
            'cf_connecting_ip' => $request->header('CF-Connecting-IP'),
            'x_forwarded_for' => $request->header('X-Forwarded-For'),
            'x_real_ip' => $request->header('X-Real-IP'),
        ])->header('Cache-Control', 'no-store, private');
    }

    private function verifySecret(Request $request, ?string $secret): void
    {
        $provided = $request->query('secret');

        if (
            $secret === null ||
            $secret === '' ||
            ! is_string($provided)
            || ! hash_equals($secret, $provided)
        ) {
            abort(404);
        }
    }
}
