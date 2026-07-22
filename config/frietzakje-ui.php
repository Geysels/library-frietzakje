<?php

return [

    'apps' => [],

    'app' => env('FRIETZAKJE_APP'),

    /*
    |--------------------------------------------------------------------------
    | Brand
    |--------------------------------------------------------------------------
    |
    | The business/brand name shown in the wordmark spots across the suite — the
    | navbar, the sign-in screen, the loading splash and the footer copyright.
    | This is the SINGLE place the brand is rendered from, so a rename is one
    | edit here (or set APP_BRAND per app). App-specific labels ("Voorraad",
    | "Planning") stay in APP_NAME / the app switcher, never in the wordmark.
    |
    */

    'brand' => env('APP_BRAND', "'t Frietzakje"),

    /*
    |--------------------------------------------------------------------------
    | App codes
    |--------------------------------------------------------------------------
    |
    | Two-letter code per suite app, keyed by the app key ('app' above /
    | FRIETZAKJE_APP). Shown in the build stamp so a version a user reports is
    | unambiguously tied to an app, e.g. "v3.28.0 · UI · e3ad64e".
    |
    | The app KEY is the real unique id; these are human-friendly labels. Keep
    | them unique — a test (Frietzakje\Ui\BuildStamp / the suite's code test)
    | enforces it. Add one line here when a new app joins the suite.
    |
    */

    'codes' => [
        'ui' => 'UI',
        'planning' => 'PL',
        'stock' => 'ST',
    ],

    'nav' => [],

    'colors' => [
        'bg' => '#1b1b1e',
        'text' => '#efefef',
        'primary' => '#fedb00',
        'secondary' => '#303030',
        'accent' => '#3901c5',
        'accent-2' => '#3f9ffc',
        'success' => '#2ac427',
        'warning' => '#ff9500',
        'danger' => '#ff4444',
        'message' => '#02a4c8',
    ],

    'icons' => [
        'system' => 'material-symbols',
    ],

];
