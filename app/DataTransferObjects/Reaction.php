<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;

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

    public static function multipleFromArray(array $reactions): array
    {
        return Arr::map(
            $reactions,
            static fn (array $reactions): Reaction => self::fromArray($reactions)
        );
    }
}
