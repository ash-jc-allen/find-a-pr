<?php

namespace Tests\Feature\RepoService;

use App\Services\RepoService;
use Tests\TestCase;

class ReposToCrawlTest extends TestCase
{
    /** @test */
    public function correct_config_is_returned(): void
    {
        config(['repos.repos' => [
            'ash-jc-allen' => [
                'find-a-pr',
                'favicon-fetcher',
                'laravel-config-validator',
                'short-url',
                'laravel-exchange-rates',
            ],
            'laravel' => [
                'framework',
                'docs',
                'vapor-core',
                'octane',
            ],
            'laravelio' => [
                'laravel.io',
            ],
            'laravel-filament' => [
                'filament',
            ],
        ]]);

        $expectedResult = [
            [
                'owner' => 'ash-jc-allen',
                'name' => 'find-a-pr',
            ],
            [
                'owner' => 'ash-jc-allen',
                'name' => 'favicon-fetcher',
            ],
            [
                'owner' => 'ash-jc-allen',
                'name' => 'laravel-config-validator',
            ],
            [
                'owner' => 'ash-jc-allen',
                'name' => 'short-url',
            ],
            [
                'owner' => 'ash-jc-allen',
                'name' => 'laravel-exchange-rates',
            ],
            [
                'owner' => 'laravel',
                'name' => 'framework',
            ],
            [
                'owner' => 'laravel',
                'name' => 'docs',
            ],
            [
                'owner' => 'laravel',
                'name' => 'vapor-core',
            ],
            [
                'owner' => 'laravel',
                'name' => 'octane',
            ],
            [
                'owner' => 'laravelio',
                'name' => 'laravel.io',
            ],
            [
                'owner' => 'laravel-filament',
                'name' => 'filament',
            ],
        ];

        self::assertEquals($expectedResult, (new RepoService())->reposToCrawl());
    }
}
