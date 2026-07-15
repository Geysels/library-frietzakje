<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The Suite
    |--------------------------------------------------------------------------
    |
    | Every application in the Frietzakje ecosystem, in the order they appear in
    | the app switcher. Each app deploys and runs on its own — the switcher is
    | what makes them feel like one product rather than five bookmarks.
    |
    | `key` matches FRIETZAKJE_APP in an app's own .env, so an app can recognise
    |       which entry is itself and mark it as current.
    | `url` is absolute: these are separate deployments, not routes.
    |
    */
    'apps' => [
        [
            'key' => 'platform',
            'name' => 'Platform',
            'description' => 'Accounts, access and the design system',
            'icon' => 'apps',
            'url' => env('FRIETZAKJE_URL_PLATFORM', 'http://localhost:8000'),
        ],
        [
            'key' => 'planning',
            'name' => 'Planning',
            'description' => 'Shifts, availability and the roster',
            'icon' => 'calendar_month',
            'url' => env('FRIETZAKJE_URL_PLANNING', 'https://planning.frietzakje.com'),
        ],
    ],

    /*
    | Which entry in `apps` is the application currently running. Set
    | FRIETZAKJE_APP in each app's .env. Null means "not part of the suite", and
    | the switcher hides itself rather than pretending.
    */
    'app' => env('FRIETZAKJE_APP'),

    /*
    |--------------------------------------------------------------------------
    | Sidebar navigation
    |--------------------------------------------------------------------------
    |
    | One sidebar, rendered by the shared layout from this data — so every app in
    | the suite looks and behaves identically and an app only supplies the entries.
    | Override it in the consuming app's own config/frietzakje-ui.php. See the
    | <x-frietzakje::sidebar-nav> component for the item shape. A page can still
    | pass its own `navigation` slot to override entirely.
    |
    */
    'nav' => [],

    /*
    |--------------------------------------------------------------------------
    | Design Tokens
    |--------------------------------------------------------------------------
    |
    | These MUST match the `@theme` block in resources/css/frietzakje-ui.css.
    | Tailwind reads the stylesheet; the API and any tooling read this. Nothing
    | can feed both, so the two are held in step by a test (PaletteTest) that
    | parses the stylesheet and fails if they drift.
    |
    | They HAD drifted: `danger` was #cb0202 here, #ff6b6b in the package
    | stylesheet and #ff4444 in the consuming app — and the public API served the
    | first of those three. Anything trusting this file was handed a colour that
    | nothing on screen actually rendered.
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
        'warning' => '#ff9500',
        'danger' => '#ff4444',
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
