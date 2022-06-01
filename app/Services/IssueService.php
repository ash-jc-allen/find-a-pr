<?php

namespace App\Services;

use App\DataTransferObjects\Issue;
use App\DataTransferObjects\IssueOwner;
use App\DataTransferObjects\Label;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IssueService
{
    private const BASE_URL = 'https://api.github.com/repos/';

    /**
     * Get all the issues for displaying.
     *
     * @param  string|null  $sort
     * @param  string  $sortDirection
     * @return array<Issue>
     */
    public function getAll(?string $sort, string $sortDirection = 'asc'): array
    {
        return app(RepoService::class)->reposToCrawl()
            ->flatMap(fn (array $repo): array => $this->getIssuesForRepo($repo))
            ->when(
                $sort,
                fn (Collection $collection): Collection => $collection->sortBy($sort, descending: $sortDirection === 'desc'),
                fn (Collection $collection): Collection => $collection->shuffle()
            )
            ->all();
    }

    /**
     * @param  array  $repo
     * @return array<Issue>
     */
    private function getIssuesForRepo(array $repo): array
    {
        $url = self::BASE_URL.$repo['owner'].'/'.$repo['name'].'/issues';

        $fetchedIssues = Cache::remember(
            $url,
            now()->addMinutes(120),
            static fn () => Http::get($url)->json()
        );

        return collect($fetchedIssues)
            ->map(fn ($issue) => $this->shouldIncludeIssue($issue) ? $this->parseIssue($repo, $issue) : null)
            ->filter()
            ->all();
    }

    private function parseIssue(array $repo, array $fetchedIssue): ?Issue
    {
        $repoName = $repo['owner'].'/'.$repo['name'];

        return new Issue(
            repoName: $repoName,
            repoUrl: 'https://github.com/'.$repoName,
            title: $fetchedIssue['title'],
            url: $fetchedIssue['html_url'],
            body: $fetchedIssue['body'],
            labels: $this->getIssueLabels($fetchedIssue),
            createdAt: Carbon::parse($fetchedIssue['created_at']),
            createdBy: $this->getIssueOwner($fetchedIssue),
        );
    }

    private function shouldIncludeIssue(array $fetchedIssue): bool
    {
        return ! $this->issueIsAPullRequest($fetchedIssue)
            && $this->includesAtLeastOneLabel($fetchedIssue, config('repos.labels'));
    }

    private function includesAtLeastOneLabel(array $fetchedIssue, mixed $labels): bool
    {
        $issueLabels = Arr::pluck($fetchedIssue['labels'], 'name');

        return array_intersect($issueLabels, $labels) !== [];
    }

    private function issueIsAPullRequest(array $fetchedIssue): bool
    {
        return isset($fetchedIssue['pull_request']);
    }

    private function getIssueOwner(array $fetchedIssue): IssueOwner
    {
        return new IssueOwner(
            name: $fetchedIssue['user']['login'],
            url: $fetchedIssue['user']['html_url'],
            profilePictureUrl: $fetchedIssue['user']['avatar_url'],
        );
    }

    /**
     * @param  array<Label>  $fetchedIssue
     * @return array
     */
    private function getIssueLabels(array $fetchedIssue): array
    {
        return collect($fetchedIssue['labels'])
            ->map(function (array $label): Label {
                return new Label(
                    name: $label['name'],
                    color: '#'.$label['color'],
                );
            })->toArray();
    }
}
