<?php

use Livewire\Component;

test('livewire')
    ->expect('App\Http\Livewire')
    ->toBeClasses()
    ->toExtend(Component::class);
