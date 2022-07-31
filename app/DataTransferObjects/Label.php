<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;

class Label
{
    public function __construct(
        public readonly string $name,
        public readonly string $color,
    ) {
        //
    }

    /**
     * @param array<string, string> $label
     * @return Label
     */
    public static function fromArray(array $label): self
    {
        return new self(...$label);
    }

    /**
     * @param array<array<string, string>> $labels
     * @return array<Label>
     */
    public static function multipleFromArray(array $labels): array
    {
        return Arr::map(
            $labels,
            static fn (array $label): Label => self::fromArray($label)
        );
    }
}
