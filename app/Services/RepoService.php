<?php

namespace App\Services;

use App\Clients\GitHub;
use App\DataTransferObjects\Repository;
use App\Exceptions\GitHubRateLimitException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RepoService
{
    public function reposToCrawl(): Collection
    {
        return collect(config('repos.repos'))
            ->flatMap(function (array $repoNames, string $owner): array {
                return Arr::map(
                    $repoNames,
                    static fn (string $repoName): Repository => new Repository($owner, $repoName)
                );
            })
            ->filter(fn (Repository $repository): bool => $this->repoCanBeCrawled($repository));
    }

    private function repoCanBeCrawled(Repository $repository): bool
    {
        $repositoryData = $this->cacheRepoData($repository);

        return !empty($repositoryData)
            && !$this->repoIsArchived($repositoryData);
    }

    private function cacheRepoData(Repository $repo): array
    {
        $cacheKey = $repo->owner.'/'.$repo->name.'-repo';

        return Cache::remember(
            $cacheKey,
            now()->addDay(),
            fn (): array => $this->getRepoFromGitHubApi($repo),
        );
    }

    private function repoIsArchived(array $repoData): bool
    {
        return $repoData['archived'] ?? true;
    }

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
     * @param  Response  $response
     * @param  string  $fullRepoName
     * @return array
     *
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
