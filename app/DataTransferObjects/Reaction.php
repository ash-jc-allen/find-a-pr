<?php

namespace App\DataTransferObjects;

class Reaction
{
    public function __construct(
        public readonly string $content,
        public readonly string $count,
        public readonly string $emoji,
    ) {
        //
    }

    public static function fromArray(array $reaction): self
    {
        return new self(...$reaction);
    }
}
