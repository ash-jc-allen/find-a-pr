<?php

use AshAllenDesign\ConfigValidator\Services\Rule;

return [
    Rule::make('github.username')->rules(['string', 'required'])->environments(['production']),

    Rule::make('github.token')->rules(['string', 'required'])->environments(['production']),

    Rule::make('ohdear.ping_url')->rules(['url', 'required'])->environments(['production']),

    Rule::make('twitter.consumer_key')->rules(['string', 'required'])->environments(['production']),

    Rule::make('twitter.consumer_secret')->rules(['string', 'required'])->environments(['production']),

    Rule::make('twitter.access_token')->rules(['string', 'required'])->environments(['production']),

    Rule::make('twitter.access_token_secret')->rules(['string', 'required'])->environments(['production']),
];
