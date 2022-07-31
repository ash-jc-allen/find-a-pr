<?php

namespace App\DataTransferObjects;

class IssueOwner
{
    public function __construct(
        public readonly string $name,
        public readonly string $url,
        public readonly string $profilePictureUrl,
    ) {
        //
    }

    /**
     * @param array<string, string> $ownerDetails
     * @return IssueOwner
     */
    public static function fromArray(array $ownerDetails): self
    {
        return new self(...$ownerDetails);
    }
}
