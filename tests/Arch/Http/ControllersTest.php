<?php

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

test('controllers')
    ->expect('App\Http\Controllers')
    ->toBeClasses()
    ->toExtend(Controller::class)
    ->toHaveSuffix('Controller')
    ->ignoring(Controller::class);

test('base controller')
    ->expect(Controller::class)
    ->toBeAbstract()
    ->toExtend(BaseController::class);
