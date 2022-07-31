<?php

namespace App\Services;

use App\DataTransferObjects\Issue;
use App\DataTransferObjects\IssueOwner;
use App\DataTransferObjects\Label;
use App\DataTransferObjects\Reaction;
use App\DataTransferObjects\Repository;
use App\Exceptions\GitHubRateLimitException;
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
     * @return Collection<int, Issue>
     */
    public function getAll(): Collection
    {
        return app(RepoService::class)->reposToCrawl()
            ->flatMap(fn (Repository $repo): array => $this->getIssuesForRepo($repo));
    }

    /**
     * @param Repository $repo
     * @return array<Issue>
     */
    private function getIssuesForRepo(Repository $repo): array
    {
        /** @var array<int, Issue> $fetchedIssues */
        $fetchedIssues = Cache::remember(
            $repo->owner.'/'.$repo->name,
            now()->addMinutes(120),
            fn () => $this->getIssueFromGitHubApi($repo),
        );

        return collect($fetchedIssues)
            ->filter(fn ($issue) => $this->shouldIncludeIssue($issue))
            ->all();
    }

    /**
     * @param Repository $repo
     * @param array<string, string|array<string, string>> $fetchedIssue
     * @return Issue
     */
    private function parseIssue(Repository $repo, array $fetchedIssue): Issue
    {
        $repoName = $repo->owner.'/'.$repo->name;

        return new Issue(
            repoName: $repoName,
            repoUrl: 'https://github.com/'.$repoName,
            title: $fetchedIssue['title'],
            url: $fetchedIssue['html_url'],
            body: $fetchedIssue['body'],
            labels: $this->getIssueLabels($fetchedIssue),
            reactions: $this->getIssueReactions($fetchedIssue),
            commentCount: (int)$fetchedIssue['comments'],
            createdAt: Carbon::parse($fetchedIssue['created_at']),
            createdBy: $this->getIssueOwner($fetchedIssue),
            isPullRequest: !empty($fetchedIssue['pull_request']),
        );
    }

    /**
     * @param Issue $fetchedIssue
     * @return bool
     */
    private function shouldIncludeIssue(Issue $fetchedIssue): bool
    {
        return ! $fetchedIssue->isPullRequest
            && $this->includesAtLeastOneLabel($fetchedIssue, config('repos.labels'));
    }

    private function includesAtLeastOneLabel(Issue $fetchedIssue, mixed $labels): bool
    {
        $issueLabels = Arr::pluck($fetchedIssue->labels, 'name');

        return array_intersect($issueLabels, $labels) !== [];
    }

    /**
     * @param array<string, string|array<string, string>> $fetchedIssue
     * @return IssueOwner
     */
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

    /**
     * @param  array<string, string|array<string, string>> $fetchedIssue
     * @return array<Label>
     */
    private function getIssueLabels(array $fetchedIssue): array
    {
        /** @var array<int, array<string, string>> $labels */
        $labels = $fetchedIssue['labels'];

        return collect($labels)
            ->map(function (array $label): Label {
                return new Label(
                    name: $label['name'],
                    color: '#'.$label['color'],
                );
            })->toArray();
    }

    /**
     * @param  array<string, string|array<string, string>> $fetchedIssue
     * @return array<Reaction>
     */
    private function getIssueReactions(array $fetchedIssue): array
    {
        $emojis = config('repos.reactions');
        /** @var array<string, int> $reactions */
        $reactions = $fetchedIssue['reactions'];

        return collect($reactions)
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
     * @param Repository $repo
     * @return array<Issue>
     *
     * @throws GitHubRateLimitException
     */
    private function getIssueFromGitHubApi(Repository $repo): array
    {
        $url = self::BASE_URL.$repo->owner.'/'.$repo->name.'/issues';

        $result = Http::get($url);

        if (! $result->successful()) {
            throw new GitHubRateLimitException('GitHub API rate limit reached!');
        }

        /** @var array<int, array<string, array<string, string>|string>> $fetchedIssues */
        $fetchedIssues = $result->json();
        return collect($fetchedIssues)
            ->map(fn ($fetchedIssue) => $this->parseIssue($repo, $fetchedIssue))
            ->all();
    }
}
