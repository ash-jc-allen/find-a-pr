<?php

namespace App\DataTransferObjects;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Livewire\Wireable;

class Issue
{
    public readonly int $interactionsCount;

    /**
     * @param string $repoName
     * @param string $repoUrl
     * @param string $title
     * @param string $url
     * @param string|null $body
     * @param array<Label> $labels
     * @param array<Reaction> $reactions
     * @param int $commentCount
     * @param CarbonInterface $createdAt
     * @param IssueOwner $createdBy
     * @param bool $isPullRequest
     */
    public function __construct(
        public readonly string $repoName,
        public readonly string $repoUrl,
        public readonly string $title,
        public readonly string $url,
        public readonly ?string $body,
        public readonly array $labels,
        public readonly array $reactions,
        public readonly int $commentCount,
        public readonly CarbonInterface $createdAt,
        public readonly IssueOwner $createdBy,
        public readonly bool $isPullRequest,
    ) {
        $this->interactionsCount = collect($this->reactions)->reduce(fn ($carry, $reaction) => $reaction->count + $carry, $this->commentCount);
    }

    /**
     * @param array<string, string|array<string, string>|array<array<string, string>>> $issueDetails
     */
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
