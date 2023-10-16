<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Livewire\Wireable;

final readonly class IssueOwner implements Wireable
{
    public function __construct(
        public string $name,
        public string $url,
        public string $profilePictureUrl,
    ) {
        //
    }

    public function toLivewire()
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
            'profilePictureUrl' => $this->profilePictureUrl,
        ];
    }

    public static function fromLivewire($value)
    {
        return self::fromArray([
            'name' => $value['name'],
            'url' => $value['url'],
            'profilePictureUrl' => $value['profilePictureUrl'],
        ]);
    }

    public static function fromArray(array $ownerDetails): self
    {
        return new self(...$ownerDetails);
    }
}
