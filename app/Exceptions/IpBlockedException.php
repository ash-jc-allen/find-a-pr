<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

final class IpBlockedException extends Exception
{
    public function __construct(private readonly string $ip, Throwable $previous)
    {
        parent::__construct('Firewall blocked IP '.$ip.' for 30 minutes.', 0, $previous);
    }

    public function context(): array
    {
        return ['ip' => $this->ip, 'trigger' => $this->getPrevious()::class];
    }
}
