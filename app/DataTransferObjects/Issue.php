<?php

namespace App\DataTransferObjects;

use Carbon\CarbonInterface;

class Issue
{
    public function __construct(
        public readonly string $repoName,
        public readonly string $repoUrl,
        public readonly string $title,
        public readonly string $url,
        public readonly ?string $body,
        public readonly array $labels,
        public readonly CarbonInterface $createdAt,
        public readonly IssueOwner $createdBy,
    ) {
        //
    }
}
