<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Livewire\Wireable;

final readonly class Repository implements Wireable
{
    public function __construct(
        public string $owner,
        public string $name,
    ) {
        //
    }

    public function toLivewire()
    {
        return [
            'owner' => $this->owner,
            'name' => $this->name,
        ];
    }

    public static function fromLivewire($value)
    {
        return new self(
            owner: $value['owner'],
            name: $value['name'],
        );
    }

    public function __toString(): string
    {
        return $this->owner.'/'.$this->name;
    }
}
