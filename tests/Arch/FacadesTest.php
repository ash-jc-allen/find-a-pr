<?php

use Illuminate\Support\Facades\Facade;

test('facades')
    ->expect('App\Facades')
    ->toBeClasses()
    ->toExtend(Facade::class)
    ->toUseStrictTypes();
