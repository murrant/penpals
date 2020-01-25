<?php

return [
    'addresses' => [
        'allotment' => env('PENPALS_ALLOTMENT', 10),
        'max' => env('PENPALS_MAX_ADDRESSES', 250),
    ],
    'registration' => [
        'open' => env('PENPALS_REGISTRATION_OPEN', true),
    ],
];
