<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

readonly class Repository
{
    public function __construct(
        public string $owner,
        public string $name,
    ) {
        //
    }

    public function __toString(): string
    {
        return $this->owner.'/'.$this->name;
    }
}
