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
}
