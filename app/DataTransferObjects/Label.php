<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;

readonly class Label
{
    public function __construct(
        public string $name,
        public string $color,
    ) {
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
