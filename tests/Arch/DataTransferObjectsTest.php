<?php

test('data transfer objects')
    ->expect('App\DataTransferObjects')
    ->toBeClasses()
    ->toBeReadonly()
    ->toExtendNothing()
    ->toUseStrictTypes();
