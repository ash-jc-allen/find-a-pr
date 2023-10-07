<?php

test('clients')
    ->expect('App\Clients')
    ->toBeClasses()
    ->toUseStrictTypes()
    ->toExtendNothing();
