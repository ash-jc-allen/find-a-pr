<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListIssuesRequest;
use App\Services\IssueService;
use App\Services\RepoService;
use Illuminate\Contracts\View\View;

class IssueController extends Controller
{
    public function __invoke(ListIssuesRequest $request, IssueService $issueService): View
    {
        return view('issues.index', [
            'labels' => config('repos.labels'),
            'repos' => app(RepoService::class)->reposToCrawl()->sort(),
            'issues' => $issueService->getAll(
                $request->determineSortField(),
                $request->determineSortDirection()
            ),
        ]);
    }
}
