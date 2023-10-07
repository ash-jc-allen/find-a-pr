<?php

use Illuminate\Contracts\Queue\ShouldQueue;

test('jobs')
    ->expect('App\Jobs')
    ->toBeClasses()
    ->toImplement(ShouldQueue::class)
    ->toUseStrictTypes();
