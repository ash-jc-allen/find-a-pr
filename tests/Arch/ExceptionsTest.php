<?php

use App\Exceptions\Handler;

test('exceptions')
    ->expect('App\Exceptions')
    ->toBeClasses()
    ->toExtend(\Exception::class)
    ->ignoring(Handler::class);
