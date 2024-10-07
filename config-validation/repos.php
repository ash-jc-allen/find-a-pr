<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('orgs')->rules(['required', 'array']),

    Rule::make('repos')->rules(['required', 'array']),

    Rule::make('labels')->rules(['required', 'array']),

    Rule::make('reactions')->rules(['required', 'array']),
];
