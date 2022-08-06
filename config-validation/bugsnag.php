<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('api_key')->rules(['string', 'required'])->environments(['production']),
];
