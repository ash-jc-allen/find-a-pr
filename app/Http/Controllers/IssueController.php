<?php

namespace App\Http\Controllers;

use App\Services\IssueService;
use Illuminate\Contracts\View\View;

class IssueController extends Controller
{
    private $sort;

    public function __invoke(IssueService $issueService): View
    {
        $sortBy = in_array(request('sort'), ['title', 'repoName', 'createdAt'], true)
            ? request('sort')
            : null;

        return view('issues.index', [
            'issues' => $issueService->getAll($sortBy),
        ]);
    }
}
