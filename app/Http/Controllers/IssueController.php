<?php

namespace App\Http\Controllers;

use App\Services\IssueService;
use Illuminate\Contracts\View\View;

class IssueController extends Controller
{
    private const ACCEPTABLE_SORT_FIELDS = ['title', 'repoName', 'createdAt'];
    private $sort;

    public function __construct()
    {
        $this->sort = null;

        if(request()->query('sort')) {
            if (in_array(request()->query('sort'), self::ACCEPTABLE_SORT_FIELDS)) {
                $this->sort = request()->query('sort');
            }
        }
    }

    public function __invoke(IssueService $issueService): View
    {
        return view('issues.index', [
            'issues' => $issueService->getAll($this->sort),
        ]);
    }
}
