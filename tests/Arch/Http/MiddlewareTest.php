<?php

test('middleware')
    ->expect('App\Http\Middleware')
    ->toBeClasses()
    ->toHaveMethod('handle')
    ->toUseStrictTypes();
