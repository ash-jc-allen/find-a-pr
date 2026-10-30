<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Services\Firewall;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Livewire\Exceptions\ComponentNotFoundException;
use Livewire\Features\SupportFileUploads\MissingFileUploadsTraitException;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Mechanisms\HandleComponents\CorruptComponentPayloadException;
use Override;
use Throwable;

final class Handler extends ExceptionHandler
{
    /**
     * @var array<int, class-string<Throwable>>
     */
    protected array $firewallBlockableExceptions = [
        ComponentNotFoundException::class,
        CannotUpdateLockedPropertyException::class,
        CorruptComponentPayloadException::class,
        MissingFileUploadsTraitException::class,
    ];

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    #[Override]
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            $ip = request()->ip();

            if ($ip === null || ! config('features.enable_firewall')) {
                return;
            }

            foreach ($this->firewallBlockableExceptions as $exceptionClass) {
                if ($e instanceof $exceptionClass) {
                    app(Firewall::class)->block($ip, $e);

                    return;
                }
            }
        });
    }
}
