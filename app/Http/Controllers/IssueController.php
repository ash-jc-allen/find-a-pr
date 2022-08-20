<?php

namespace App\Http\Controllers;

use App\Services\IssueService;
use Illuminate\Contracts\View\View;

class IssueController extends Controller
{
    public function __invoke(IssueService $issueService): View
    {
        return view('issues.index');
    }
}
