<?php

namespace App\Services;

use App\DataTransferObjects\Repository;
use Illuminate\Support\Collection;

class RepoService
{
    /**
     * Loop through the repos specified in the config and return them in
     * a format that can be used in the application.
     *
     * @return Collection<int, Repository>
     */
    public function reposToCrawl(): Collection
    {
        $repos = (array) config('repos.repos');

        return collect($repos)
            ->flatMap(function (array $repoNames, string $owner): array {
                return collect($repoNames)
                    ->map(fn(string $repoName): Repository => new Repository($owner, $repoName))
                    ->all();
            });
    }
}
