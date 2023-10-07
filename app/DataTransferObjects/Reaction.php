<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;

final readonly class Reaction
{
    public function __construct(
        public string $content,
        public int $count,
        public string $emoji,
    ) {
        //
    }

    public static function fromArray(array $reaction): self
    {
        return new self(...$reaction);
    }

    public static function multipleFromArray(array $labels): array
    {
        return Arr::map(
            $labels,
            static fn (array $label): Reaction => self::fromArray($label)
        );
    }
}
