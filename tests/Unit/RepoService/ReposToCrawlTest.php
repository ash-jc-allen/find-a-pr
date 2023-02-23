<?php

namespace Tests\Unit\RepoService;

use App\DataTransferObjects\Repository;
use App\Services\RepoService;
use Tests\TestCase;

class ReposToCrawlTest extends TestCase
{
    /** @test */
    public function correct_config_is_returned(): void
    {
        config([
            'repos' => [
                'repos' => [
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
                ],
            ],
        ]);

        $expectedResult = [
            new Repository('ash-jc-allen', 'find-a-pr'),
            new Repository('ash-jc-allen', 'favicon-fetcher'),
            new Repository('ash-jc-allen', 'laravel-config-validator'),
            new Repository('ash-jc-allen', 'short-url'),
            new Repository('ash-jc-allen', 'laravel-exchange-rates'),
            new Repository('laravel', 'framework'),
            new Repository('laravel', 'docs'),
            new Repository('laravel', 'vapor-core'),
            new Repository('laravel', 'octane'),
            new Repository('laravelio', 'laravel.io'),
            new Repository('laravel-filament', 'filament'),
        ];

        self::assertEquals($expectedResult, (new RepoService())->reposToCrawl()->toArray());
    }
}
