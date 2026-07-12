<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Component Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix used for all Frietzakje UI components. By default, components
    | are accessible as <x-frietzakje::button>, <x-frietzakje::card>, etc.
    |
    */
    'prefix' => 'frietzakje',

    /*
    |--------------------------------------------------------------------------
    | Design System
    |--------------------------------------------------------------------------
    |
    | Default design tokens for the Frietzakje UI component library.
    | These can be overridden in your application's CSS.
    |
    */
    'colors' => [
        'bg' => '#1b1b1e',
        'text' => '#efefef',
        'primary' => '#fedb00',
        'secondary' => '#303030',
        'accent' => '#3901c5',
        'accent-2' => '#3f9ffc',
        'success' => '#2ac427',
        'danger' => '#cb0202',
        'message' => '#02a4c8',
    ],

    /*
    |--------------------------------------------------------------------------
    | Icon System
    |--------------------------------------------------------------------------
    |
    | The icon system used by the Icon component. Currently supports
    | Material Symbols Outlined.
    |
    */
    'icons' => [
        'system' => 'material-symbols',
    ],
];
