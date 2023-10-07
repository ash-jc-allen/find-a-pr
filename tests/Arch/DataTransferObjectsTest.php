<?php

test('data transfer objects')
    ->expect('App\DataTransferObjects')
    ->toBeClasses()
    ->toExtendNothing();
