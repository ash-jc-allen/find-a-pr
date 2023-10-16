<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Illuminate\Support\Arr;
use Livewire\Wireable;

final readonly class Reaction implements Wireable
{
    public function __construct(
        public string $content,
        public int $count,
        public string $emoji,
    ) {
        //
    }

    public function toLivewire()
    {
        return [
            'content' => $this->content,
            'count' => $this->count,
            'emoji' => $this->emoji,
        ];
    }

    public static function fromLivewire($value)
    {
        return self::fromArray([
            'content' => $value['content'],
            'count' => $value['count'],
            'emoji' => $value['emoji'],
        ]);
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
