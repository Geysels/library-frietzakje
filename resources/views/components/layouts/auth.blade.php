{{-- Chrome-free layout for sign-in, sign-up and password reset: no nav, no sidebar.
     Optional `$aside` slot fills the right half on desktop with a brand panel. --}}
@props([
    'title' => null,
    'heading' => null,
    'subheading' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1b1b1e">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700&family=Nunito:wght@300;400;500;600;700;800;900&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,300..700,0..1,-50..200&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $head ?? '' }}
</head>
<body class="min-h-screen bg-bg text-text antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        {{-- Form column --}}
        <div class="flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-16">
            <div class="mx-auto w-full max-w-sm">
                <div class="mb-8 flex items-center gap-2.5">
                    @if (file_exists(public_path('logo.svg')))
                        <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}" class="size-9 rounded-md">
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

    <x-frietzakje-toast position="top-right" />

    {{ $scripts ?? '' }}
</body>
</html>
