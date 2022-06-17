<?php

namespace App\DataTransferObjects;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class Issue
{
    public readonly int $interactionsCount;

    public function __construct(
        public readonly string $repoName,
        public readonly string $repoUrl,
        public readonly string $title,
        public readonly string $url,
        public readonly ?string $body,
        public readonly array $labels,
        public readonly array $reactions,
        public readonly CarbonInterface $createdAt,
        public readonly IssueOwner $createdBy,
    ) {
        $this->interactionsCount = collect($this->reactions)->reduce(fn ($carry, $reaction) => ($carry ?? 0) + $reaction->count);
    }

    public static function fromArray(array $issueDetails): self
    {
        $issueDetails['createdAt'] = Carbon::parse($issueDetails['createdAt']);
        $issueDetails['createdBy'] = IssueOwner::fromArray($issueDetails['createdBy']);
        $issueDetails['labels'] = Label::multipleFromArray($issueDetails['labels']);
        $issueDetails['reactions'] = Reaction::multipleFromArray($issueDetails['reactions']);

        unset($issueDetails['interactionsCount']);

        return new self(...$issueDetails);
    }
}
