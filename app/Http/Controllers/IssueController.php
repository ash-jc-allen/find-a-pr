<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListIssuesRequest;
use App\Services\IssueService;
use Illuminate\Contracts\View\View;

class IssueController extends Controller
{
    public function __invoke(ListIssuesRequest $request, IssueService $issueService): View
    {
        return view('issues.index', [
            'issues' => $issueService->getAll(
                $request->determineSortField(),
                $request->determineSortDirection()
            ),
        ]);
    }
}
