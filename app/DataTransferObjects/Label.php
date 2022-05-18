<?php

namespace App\DataTransferObjects;

class Label
{
    public function __construct(
        public readonly string $name,
        public readonly string $color,
    )
    {
        //
    }
}
