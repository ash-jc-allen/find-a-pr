<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;

class Label
{
    public function __construct(
        public readonly string $name,
        public readonly string $color,
    )
    {
        //
    }

    public static function fromArray(array $label): self
    {
        return new self(...$label);
    }

    public static function multipleFromArray(array $labels): array
    {
        return Arr::map(
            $labels,
            static fn (array $label): Label => self::fromArray($label)
        );
    }
}
