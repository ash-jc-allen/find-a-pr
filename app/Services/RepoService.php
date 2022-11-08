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

final class RepoService
{
    public function reposToCrawl(): Collection
    {
        return collect(config('repos.repos'))
            ->flatMap(function (array $repoNames, string $owner): array {
                return Arr::map(
                    $repoNames,
                    static fn (string $repoName): Repository => new Repository($owner, $repoName)
                );
            });
    }

    /**
     * @param  Repository  $repository
     * @return void
     *
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
     * @param  Repository  $repo
     * @return array
     *
     * @throws GitHubRateLimitException
     * @throws RepoNotCrawlableException
     */
    private function getRepoFromGitHubApi(Repository $repo): array
    {
        $fullRepoName = $repo->owner.'/'.$repo->name;

        $result = app(GitHub::class)
            ->client()
            ->get($fullRepoName);

        if (! $result->successful()) {
            return $this->handleUnsuccessfulIssueRequest($result, $fullRepoName);
        }

        return $result->json();
    }

    /**
     * @param  Response  $response
     * @param  string  $fullRepoName
     * @return array
     *
     * @throws GitHubRateLimitException
     * @throws RepoNotCrawlableException
     */
    private function handleUnsuccessfulIssueRequest(Response $response, string $fullRepoName): array
    {
        match ($response->status()) {
            404 => $this->handleNotFoundResponse($fullRepoName),
            403 => $this->handleForbiddenResponse($response, $fullRepoName),
            default => throw new RepoNotCrawlableException('Unknown error for repo '.$fullRepoName),
        };
    }

    /**
     * @param  string  $fullRepoName
     * @return void
     *
     * @throws RepoNotCrawlableException
     */
    private function handleNotFoundResponse(string $fullRepoName): void
    {
        throw new RepoNotCrawlableException($fullRepoName.' is not a valid GitHub repo.');
    }

    /**
     * @param  Response  $response
     * @param  string  $fullRepoName
     * @return void
     *
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
}
