<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('enable_firewall')->rules(['required', 'boolean']),
];
