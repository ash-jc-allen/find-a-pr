<?php

declare(strict_types=1);

namespace App\Services;

use App\Clients\GitHub;
use App\DataTransferObjects\Repository;
use App\Exceptions\GitHubRateLimitException;
use App\Exceptions\RepoNotCrawlableException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final readonly class RepoService
{
    public function reposToCrawl(): Collection
    {
        return collect(config('repos.repos'))
            ->merge($this->fetchReposFromOrgs())
            ->flatMap(function (array $repoNames, string $owner): array {
                return Arr::map(
                    $repoNames,
                    static fn (string $repoName): Repository => new Repository($owner, $repoName)
                );
            });
    }

    /**
     * @throws GitHubRateLimitException
     * @throws RepoNotCrawlableException
     */
    public function ensureRepoCanBeCrawled(Repository $repository): void
    {
        $repositoryData = $this->getRepoFromGitHubApi($repository);

        if ($this->repoIsArchived($repositoryData)) {
            throw new RepoNotCrawlableException(
                "Repository {$repository->owner}/{$repository->name} is archived."
            );
        }
    }

    private function repoIsArchived(array $repoData): bool
    {
        return $repoData['archived'] ?? true;
    }

    /**
     * @throws GitHubRateLimitException
     * @throws RepoNotCrawlableException
     */
    private function getRepoFromGitHubApi(Repository $repo): array
    {
        $fullRepoName = $repo->owner.'/'.$repo->name;

        $result = app(GitHub::class)
            ->client()
            ->get('repos/'.$fullRepoName);

        if (! $result->successful()) {
            $this->handleUnsuccessfulIssueRequest($result, $fullRepoName);
        }

        return $result->json();
    }

    /**
     * @throws GitHubRateLimitException
     * @throws RepoNotCrawlableException
     */
    private function handleUnsuccessfulIssueRequest(Response $response, string $fullRepoName): void
    {
        match ($response->status()) {
            404 => $this->handleNotFoundResponse($fullRepoName),
            403 => $this->handleForbiddenResponse($response, $fullRepoName),
            default => throw new RepoNotCrawlableException('Unknown error for repo '.$fullRepoName),
        };
    }

    /**
     * @throws RepoNotCrawlableException
     */
    private function handleNotFoundResponse(string $fullRepoName): void
    {
        throw new RepoNotCrawlableException($fullRepoName.' is not a valid GitHub repo.');
    }

    /**
     * @throws GitHubRateLimitException
     * @throws RepoNotCrawlableException
     */
    private function handleForbiddenResponse(Response $response, string $fullRepoName): void
    {
        if ($response->header('X-RateLimit-Remaining') === '0') {
            throw new GitHubRateLimitException('GitHub API rate limit reached!');
        }

        throw new RepoNotCrawlableException($fullRepoName.' is a forbidden GitHub repo.');
    }

    private function fetchReposFromOrgs(): Collection
    {
        return collect(config('repos.orgs'))
            ->mapWithKeys(fn (string $org): array => [$org => $this->fetchReposFromOrg($org)]);
    }

    /**
     * Fetch all the crawlable repos for a GitHub organization.
     */
    private function fetchReposFromOrg(string $org): array
    {
        return Cache::remember(
            key: 'repos.orgs.'.$org,
            ttl: now()->addWeek(),
            callback: function () use ($org): array {
                $client = app(GitHub::class)->client();
                $page = 1;

                $repos = collect();

                while ($result = $client->get("orgs/{$org}/repos", ['per_page' => 100, 'type' => 'sources', 'page' => $page])->json()) {
                    $repoNames = collect($result)
                        ->reject(fn (array $repo): bool => $this->repoIsArchived($repo))
                        ->pluck('name');

                    $repos->push(...$repoNames);

                    $page++;
                }

                return $repos->all();
            }
        );
    }
}
