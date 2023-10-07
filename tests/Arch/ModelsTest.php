<?php

use Illuminate\Database\Eloquent\Model;

test('models')
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend(Model::class);
