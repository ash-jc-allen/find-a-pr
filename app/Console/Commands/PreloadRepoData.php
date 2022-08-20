<?php

namespace App\Console\Commands;

use App\DataTransferObjects\Repository;
use App\Jobs\PreloadIssuesForRepo;
use App\Services\RepoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;

class PreloadRepoData extends Command
{
    protected $signature = 'repos:preload';

    protected $description = 'Preload the repos and cache them to improve load time.';

    public function handle(): int
    {
        $this->components->info('Preloading and caching issues...');

        $jobs = app(RepoService::class)
            ->reposToCrawl()
            ->map(fn (Repository $repo): PreloadIssuesForRepo => new PreloadIssuesForRepo($repo))
            ->all();

        $this->components->info('Dispatching '.count($jobs).' jobs in a batch to find issues.');

        logger('start');
        Bus::batch($jobs)
            ->then(function (): void {
                logger('end');
                Artisan::call('issues:tweet');
            })
            ->dispatch();

        $this->components->info('Dispatched!');

        return 0;
    }
}
