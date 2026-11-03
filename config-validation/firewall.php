<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('ip_check_secret')->rules(['required', 'string']),
];
