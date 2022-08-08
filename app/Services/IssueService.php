<?php

namespace App\Services;

use App\Clients\GitHub;
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

class IssueService
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
     * @param  Repository  $repo
     * @return array<Issue>
     */
    private function getIssuesForRepo(Repository $repo): array
    {
        $fetchedIssues = Cache::remember(
            $repo->owner.'/'.$repo->name,
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

    /**
     * @param  array<Reaction>  $fetchedIssue
     * @return array
     */
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
     * @param  Repository  $repo
     * @return array<Issue>
     *
     * @throws GitHubRateLimitException
     */
    private function getIssuesFromGitHubApi(Repository $repo): array
    {
        $result = app(GitHub::class)
            ->client()
            ->get($repo->owner.'/'.$repo->name.'/issues');

        if (! $result->successful()) {
            throw new GitHubRateLimitException('GitHub API rate limit reached!');
        }

        $fetchedIssues = $result->json();

        return collect($fetchedIssues)
            ->map(fn (array $fetchedIssue): Issue => $this->parseIssue($repo, $fetchedIssue))
            ->all();
    }
}
