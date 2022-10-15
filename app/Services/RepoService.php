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
    /**
     * Loop through the formatted repos and return filtered repos
     *
     * @return Collection
     */
    public function reposToCrawl(): Collection
    {
        return $this->getAllRepos(config('repos.repos'))
            ->map(fn (Repository $repo): array|Repository => $this->getRepo($repo))
            ->filter();
    }

    /**
    * get all formatted repos
    *
    * @return Collection
    */
    public function getAllRepos(array $repos): collection
    {
        return collect($repos)
            ->flatMap(function (array $repoNames, string $owner): array {
                return Arr::map(
                    $repoNames,
                    static fn (string $repoName): Repository => new Repository($owner, $repoName)
                );
            });
    }

    public function getRepo(Repository $repo, bool $forceRefresh = false): array|Repository
    {
        $cacheKey = $repo->owner.'/'.$repo->name.'-repo';

        if ($forceRefresh) {
            Cache::forget($cacheKey);
        }

        $fetchedRepo = Cache::remember(
            $cacheKey,
            now()->addMinutes(120),
            fn (): array => $this->getRepoFromGitHubApi($repo),
        );
        
        if(! isset($fetchedRepo['archived']) || $fetchedRepo['archived']) {
            return [];
        }

        return $repo;
    }

    public function getRepoFromGitHubApi(Repository $repo): array
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
