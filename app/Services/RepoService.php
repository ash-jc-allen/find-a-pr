<?php

namespace App\Services;

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
                return collect($repoNames)->map(function (string $repoName) use ($owner): array {
                    return [
                        'owner' => $owner,
                        'name' => $repoName,
                    ];
                })->all();
            });
    }
}
