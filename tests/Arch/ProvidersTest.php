<?php

use Illuminate\Support\ServiceProvider;

test('providers')
    ->expect('App\Providers')
    ->toBeClasses()
    ->toExtend(ServiceProvider::class)
    ->toUseStrictTypes();
