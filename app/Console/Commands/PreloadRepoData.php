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

        $repos = app(RepoService::class)
            ->reposToCrawl()
            ->map(fn(Repository $repo): PreloadIssuesForRepo => new PreloadIssuesForRepo($repo))
            ->all();

        $this->components->info('Dispatching '.count($repos).' jobs in a batch to find issues.');

        Bus::batch($repos)
            ->then(function (): void {
                Artisan::call('issues:tweet');
            })
            ->dispatch();

        $this->components->info('Dispatched!');

        return 0;
    }
}
