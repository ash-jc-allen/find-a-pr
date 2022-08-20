<?php

namespace App\Jobs;

use App\DataTransferObjects\Repository;
use App\Services\IssueService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PreloadIssuesForRepo implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly Repository $repo)
    {
        //
    }

    public function handle(IssueService $issueService): void
    {
        $issueService->getIssuesForRepo(repo: $this->repo, forceRefresh: true);
    }
}
