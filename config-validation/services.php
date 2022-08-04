<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('github.username')->rules(['string', 'required'])->environments(['production']),

    Rule::make('github.token')->rules(['string', 'required'])->environments(['production']),

    Rule::make('ohdear.ping_url')->rules(['url', 'required'])->environments(['production']),
];
