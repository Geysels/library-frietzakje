<?php

return [

    'apps' => [
        [
            'key'         => 'platform',
            'name'        => 'Backoffice',
            'description' => 'Accounts, toegang en het ontwerpsysteem',
            'icon'        => 'apps',
            'url'         => env('FRIETZAKJE_URL_PLATFORM', 'http://localhost:8000'),
        ],
        [
            'key'         => 'planning',
            'name'        => 'Planning',
            'description' => 'Shiften, beschikbaarheid en het rooster',
            'icon'        => 'calendar_month',
            'url'         => env('FRIETZAKJE_URL_PLANNING', 'https://planning.frietzakje.com'),
        ],
    ],

    'app' => env('FRIETZAKJE_APP'),

    'nav' => [],

    'colors' => [
        'bg'        => '#1b1b1e',
        'text'      => '#efefef',
        'primary'   => '#fedb00',
        'secondary' => '#303030',
        'accent'    => '#3901c5',
        'accent-2'  => '#3f9ffc',
        'success'   => '#2ac427',
        'warning'   => '#ff9500',
        'danger'    => '#ff4444',
        'message'   => '#02a4c8',
    ],

    'icons' => [
        'system' => 'material-symbols',
    ],

];
