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
     * @return Collection
     */
    public function reposToCrawl(): Collection
    {
        return collect(config('repos.repos'))
            ->flatMap(function (array $repoNames, string $owner): array {
                return collect($repoNames)->map(function (string $repoName) use ($owner): Repository {
                    return new Repository($owner, $repoName);
                })->all();
            });
    }
}
