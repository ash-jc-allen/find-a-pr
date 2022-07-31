<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;

class Reaction
{
    public function __construct(
        public readonly string $content,
        public readonly int $count,
        public readonly string $emoji,
    ) {
        //
    }

    /**
     * @param array<string, string|int> $reaction
     * @return Reaction
     */
    public static function fromArray(array $reaction): self
    {
        return new self(...$reaction);
    }

    /**
     * @param array<int, array<string, string|int>> $labels
     * @return array<int, Reaction>
     */
    public static function multipleFromArray(array $labels): array
    {
        return Arr::map(
            $labels,
            static fn (array $label): Reaction => self::fromArray($label)
        );
    }
}
