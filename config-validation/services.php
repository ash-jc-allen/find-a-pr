<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    /*
    |--------------------------------------------------------------------------
    | Local
    |--------------------------------------------------------------------------
    */
    Rule::make('github.username')->rules(['string', 'nullable'])->environments(['local']),

    Rule::make('github.token')->rules(['string', 'nullable'])->environments(['local']),

    /*
    |--------------------------------------------------------------------------
    | Production
    |--------------------------------------------------------------------------
    */
    Rule::make('github.username')->rules(['string', 'required'])->environments(['production']),

    Rule::make('github.token')->rules(['string', 'required'])->environments(['production']),
];
