<?php

namespace App\DataTransferObjects;

class Repository
{
    public function __construct(
        public readonly string $owner,
        public readonly string $name,
    ) {
        //
    }
}
