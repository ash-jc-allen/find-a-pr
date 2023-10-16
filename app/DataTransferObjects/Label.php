<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;
use Livewire\Wireable;

final readonly class Label implements Wireable
{
    public function __construct(
        public string $name,
        public string $color,
    ) {
        //
    }

    public function toLivewire()
    {
        return [
            'name' => $this->name,
            'color' => $this->color,
        ];
    }

    public static function fromLivewire($value)
    {
        return self::fromArray([
            'name' => $value['name'],
            'color' => $value['color'],
        ]);
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
