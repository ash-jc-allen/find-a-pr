<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

final readonly class IssueOwner
{
    public function __construct(
        public string $name,
        public readonly string $url,
        public readonly string $profilePictureUrl,
    ) {
        //
    }

    public static function fromArray(array $ownerDetails): self
    {
        return new self(...$ownerDetails);
    }
}
