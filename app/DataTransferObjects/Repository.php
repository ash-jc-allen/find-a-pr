<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

class Repository
{
    public function __construct(
        public readonly string $owner,
        public readonly string $name,
    ) {
        //
    }

    public function __toString(): string
    {
        return $this->owner.'/'.$this->name;
    }
}
