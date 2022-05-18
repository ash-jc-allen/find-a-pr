<?php

namespace App\Services;

use App\DataTransferObjects\Issue;
use App\DataTransferObjects\IssueOwner;
use App\DataTransferObjects\Label;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class IssueService
{
    private const BASE_URL = 'https://api.github.com/repos/';

    private const REPOS = [
        [
            'owner' => 'laravelio',
            'name' => 'laravel.io',
        ]
    ];

    public function getAll()
    {
        $issues = [];

        foreach (static::REPOS as $repo) {
            $url = self::BASE_URL . $repo['owner'] . '/' . $repo['name'] . '/issues';

            $fetchedIssues = Http::get($url)->json();

            foreach ($fetchedIssues as $fetchedIssue) {
                $issues[] = $this->parseIssue($repo, $fetchedIssue);
            }
        }

        return $issues;
    }

    private function parseIssue(array $repo, array $fetchedIssue): Issue
    {
        $repoName = $repo['owner'].'/'.$repo['name'];

        $createdBy = new IssueOwner(
            name: $fetchedIssue['user']['login'],
            url: $fetchedIssue['user']['html_url'],
            profilePictureUrl: $fetchedIssue['user']['avatar_url'],
        );

        $labels = [];

        foreach ($fetchedIssue['labels'] as $label) {
            $labels[] = new Label(
                name: $label['name'],
                color: '#'.$label['color'],
                url: $label['url'],
            );
        }

        return new Issue(
            repoName: $repoName,
            repoUrl: 'https://github.com/'.$repoName,
            title: $fetchedIssue['title'],
            url: $fetchedIssue['html_url'],
            body: $fetchedIssue['body'],
            labels: $labels,
            createdAt: Carbon::parse($fetchedIssue['created_at']),
            createdBy: $createdBy,
        );
    }
}
