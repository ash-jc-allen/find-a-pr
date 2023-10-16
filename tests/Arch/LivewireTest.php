<?php

use Livewire\Component;

test('livewire')
    ->expect('App\Livewire')
    ->toBeClasses()
    ->toExtend(Component::class)
    ->toUseStrictTypes();
