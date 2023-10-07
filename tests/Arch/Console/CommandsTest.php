<?php

use Illuminate\Console\Command;

test('commands')
    ->expect('App\Commands\Console')
    ->toBeClasses()
    ->toExtend(Command::class)
    ->toHaveMethod('handle')
    ->toUseStrictTypes();
