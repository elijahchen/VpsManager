<?php

return [
    'asset_url' => env('ASSET_URL', '/modules'),
    'paths' => [
        'modules' => base_path('Modules'),
        'assets' => public_path('modules'),
    ],
];