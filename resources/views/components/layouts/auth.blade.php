{{-- Chrome-free layout for sign-in, sign-up and password reset: no nav, no sidebar.

     Two modes:
       • Default — a two-column split, form on the left, optional `$aside` brand
         panel on the right.
       • Background — pass `background` (a path under public/) to get a full-bleed
         photo with a single centered, slightly translucent card. The `$aside`
         slot is ignored in this mode. --}}
@props([
    'title' => null,
    'heading' => null,
    'subheading' => null,
    'background' => null,
])

@php
    $hasBackground = $background && file_exists(public_path($background));

    // First logo asset that actually exists, in preference order.
    $logo = collect(['images/logo.png', 'logo.svg', 'logo.png'])
        ->first(fn ($p) => file_exists(public_path($p)));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1b1b1e">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700&family=Nunito:wght@300;400;500;600;700;800;900&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,300..700,0..1,-50..200&display=block" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $head ?? '' }}
</head>
<body class="min-h-screen bg-bg text-text antialiased">

    @include('frietzakje::partials.page-loader')

@if ($hasBackground)
    {{-- Full-bleed background photo with a centered card. --}}
    <div class="relative min-h-screen">
        {{-- The photo, and a dark scrim over it so the card and text stay legible
             regardless of how busy the image is. --}}
        <div class="fixed inset-0 bg-cover bg-center"
             style="background-image: url('{{ asset($background) }}');"></div>
        <div class="fixed inset-0 bg-bg/70"></div>

        <div class="relative flex min-h-screen items-center justify-center px-4 py-10 sm:py-16">
            <div class="w-full max-w-md rounded-2xl border border-white/10 bg-bg/80 p-8 shadow-2xl backdrop-blur-xl sm:p-10">
                <div class="mb-8 flex flex-col items-center gap-3 text-center">
                    @if ($logo)
                        <img src="{{ asset($logo) }}" alt="{{ config('app.name') }}" class="h-20 w-auto">
                    @endif
                    <span class="font-display text-xl font-bold text-primary">{{ config('app.name') }}</span>
                </div>

                @if ($heading)
                    <h1 class="mb-2 text-center">{{ $heading }}</h1>
                @endif

                @if ($subheading)
                    <p class="mb-8 text-center text-text/60"><small>{{ $subheading }}</small></p>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>
@else
    {{-- Default two-column split. --}}
    <div class="grid min-h-screen lg:grid-cols-2">
        {{-- Form column --}}
        <div class="flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-16">
            <div class="mx-auto w-full max-w-sm">
                <div class="mb-8 flex items-center gap-2.5">
                    @if ($logo)
                        <img src="{{ asset($logo) }}" alt="{{ config('app.name') }}" class="size-9 rounded-md">
                    @endif
                    <span class="font-display text-xl font-bold text-primary">{{ config('app.name') }}</span>
                </div>

                @if ($heading)
                    <h1 class="mb-2">{{ $heading }}</h1>
                @endif

                @if ($subheading)
                    <p class="mb-8 text-text/60"><small>{{ $subheading }}</small></p>
                @endif

                {{ $slot }}
            </div>
        </div>

        {{-- Brand column: decorative, so it is the first thing to go on small screens. --}}
        <div class="relative hidden overflow-hidden border-l border-secondary bg-secondary/20 lg:block">
            @isset($aside)
                {{ $aside }}
            @endisset
        </div>
    </div>
@endif

    {{-- Build identity, barely-there in the corner — so any deployed login screen
         is still identifiable by version + commit without drawing the eye. --}}
    @if (config('app.version') || config('app.commit'))
        <div class="pointer-events-none fixed bottom-2 right-3 z-50 font-mono text-[10px] leading-none text-white/20">
            {{ trim('v'.config('app.version').' · '.config('app.commit'), ' ·') }}
        </div>
    @endif

    {{-- Cookie consent — asks once, remembers the choice. --}}
    @include('frietzakje::partials.cookie-banner')

    <x-frietzakje-toast position="top-right" />

    {{ $scripts ?? '' }}
</body>
</html>
