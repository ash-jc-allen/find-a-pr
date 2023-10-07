<?php

declare(strict_types=1);

namespace App\Clients;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final readonly class GitHub
{
    private const BASE_URL = 'https://api.github.com/';

    /**
     * Build and return a client that we can use to make requests to the
     * GitHub API. If basic auth credentials are set in the config,
     * use them so that we can have a higher rate limit than
     * using the publicly accessible API.
     */
    public function client(): PendingRequest
    {
        $client = Http::baseUrl(self::BASE_URL);

        if (config('services.github.username') && config('services.github.token')) {
            $client->withBasicAuth(
                config('services.github.username'),
                config('services.github.token')
            );
        }

        return $client;
    }
}
