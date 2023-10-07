<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\PreloadIssuesForRepos;
use App\Services\RepoService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;

final class PreloadRepoData extends Command
{
    protected $signature = 'repos:preload';

    protected $description = 'Preload the repos and cache them to improve load time.';

    public function handle(): int
    {
        $this->components->info('Preloading and caching issues...');

        $batches = app(RepoService::class)
            ->reposToCrawl()
            ->chunk(25)
            ->map(function (Collection $repos): PreloadIssuesForRepos {
                return new PreloadIssuesForRepos($repos);
            })
            ->all();

        $this->components->info('Dispatching '.count($batches).' jobs in a batch to find repos.');

        Bus::batch($batches)
            ->then(function (): void {
                Artisan::call('issues:tweet');
            })
            ->dispatch();

        $this->components->info('Dispatched!');

        return 0;
    }
}
