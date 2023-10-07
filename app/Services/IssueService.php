<?php

declare(strict_types=1);

namespace App\Services;

use App\Clients\GitHub;
use App\DataTransferObjects\Issue;
use App\DataTransferObjects\IssueOwner;
use App\DataTransferObjects\Label;
use App\DataTransferObjects\Reaction;
use App\DataTransferObjects\Repository;
use App\Exceptions\GitHubRateLimitException;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final readonly class IssueService
{
    /**
     * Get all the issues for displaying.
     *
     * @return Collection<Issue>
     */
    public function getAll(): Collection
    {
        return app(RepoService::class)
            ->reposToCrawl()
            ->flatMap(fn (Repository $repo): array => $this->getIssuesForRepo($repo));
    }

    /**
     * @return array<Issue>
     */
    public function getIssuesForRepo(Repository $repo, bool $forceRefresh = false): array
    {
        $cacheKey = $repo->owner.'/'.$repo->name;

        if ($forceRefresh) {
            Cache::forget($cacheKey);
        }

        $fetchedIssues = Cache::remember(
            $cacheKey,
            now()->addMinutes(120),
            fn (): array => $this->getIssuesFromGitHubApi($repo),
        );

        return collect($fetchedIssues)
            ->filter(fn (Issue $issue): bool => $this->shouldIncludeIssue($issue))
            ->all();
    }

    private function parseIssue(Repository $repo, array $fetchedIssue): Issue
    {
        $repoName = $repo->owner.'/'.$repo->name;

        return new Issue(
            id: $fetchedIssue['id'],
            number: $fetchedIssue['number'],
            repoName: $repoName,
            repoUrl: 'https://github.com/'.$repoName,
            title: $fetchedIssue['title'],
            url: $fetchedIssue['html_url'],
            body: $fetchedIssue['body'],
            labels: $this->getIssueLabels($fetchedIssue),
            reactions: $this->getIssueReactions($fetchedIssue),
            commentCount: $fetchedIssue['comments'],
            createdAt: Carbon::parse($fetchedIssue['created_at']),
            createdBy: $this->getIssueOwner($fetchedIssue),
            isPullRequest: ! empty($fetchedIssue['pull_request']),
        );
    }

    private function shouldIncludeIssue(Issue $fetchedIssue): bool
    {
        return ! $fetchedIssue->isPullRequest
            && $this->includesAtLeastOneLabel($fetchedIssue, (array) config('repos.labels'));
    }

    private function includesAtLeastOneLabel(Issue $fetchedIssue, array $labels): bool
    {
        $issueLabels = Arr::pluck($fetchedIssue->labels, 'name');

        return array_intersect($issueLabels, $labels) !== [];
    }

    private function getIssueOwner(array $fetchedIssue): IssueOwner
    {
        // Set avatar size to 48px
        $fetchedIssue['user']['avatar_url'] .= (parse_url($fetchedIssue['user']['avatar_url'], PHP_URL_QUERY) ? '&' : '?').'s=48';

        return new IssueOwner(
            name: $fetchedIssue['user']['login'],
            url: $fetchedIssue['user']['html_url'],
            profilePictureUrl: $fetchedIssue['user']['avatar_url'],
        );
    }

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

    private function getIssueReactions(array $fetchedIssue): array
    {
        $emojis = config('repos.reactions');

        return collect($fetchedIssue['reactions'])
            ->only(array_keys($emojis))
            ->map(function (int $count, string $content) use ($emojis): Reaction {
                return new Reaction(
                    content: $content,
                    count: $count,
                    emoji: $emojis[$content]
                );
            })
            ->values()
            ->all();
    }

    /**
     * @return array<Issue>
     *
     * @throws GitHubRateLimitException
     */
    private function getIssuesFromGitHubApi(Repository $repo): array
    {
        $fullRepoName = $repo->owner.'/'.$repo->name;

        $result = app(GitHub::class)
            ->client()
            ->get('repos/'.$fullRepoName.'/issues');

        if (! $result->successful()) {
            return $this->handleUnsuccessfulIssueRequest($result, $fullRepoName);
        }

        $fetchedIssues = $result->json();

        return collect($fetchedIssues)
            ->map(fn (array $fetchedIssue): Issue => $this->parseIssue($repo, $fetchedIssue))
            ->all();
    }

    /**
     * @throws GitHubRateLimitException
     */
    private function handleUnsuccessfulIssueRequest(Response $response, string $fullRepoName): array
    {
        return match ($response->status()) {
            404 => $this->handleNotFoundResponse($fullRepoName),
            403 => $this->handleForbiddenResponse($response, $fullRepoName),
            default => [],
        };
    }

    private function handleNotFoundResponse(string $fullRepoName): array
    {
        report($fullRepoName.' is not a valid GitHub repo.');

        return [];
    }

    /**
     * @throws GitHubRateLimitException
     */
    private function handleForbiddenResponse(Response $response, string $fullRepoName): array
    {
        if ($response->header('X-RateLimit-Remaining') === '0') {
            throw new GitHubRateLimitException('GitHub API rate limit reached!');
        }

        report($fullRepoName.' is a forbidden GitHub repo.');

        return [];
    }
}
