<?php

namespace App\Console\Commands;

use App\Services\IssueService;
use Illuminate\Console\Command;

class PreloadRepoData extends Command
{
    protected $signature = 'repos:preload';

    protected $description = 'Preload the repos and cache them to improve load time.';

    public function handle(): int
    {
        $this->info('Preloading and caching issues...');

        $issues = app(IssueService::class)->getAll();

        $this->info('Preloaded '.$issues->count().' issues.');
        $this->info('Complete!');

        return 0;
    }
}
