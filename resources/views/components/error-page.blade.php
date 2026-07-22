@php
    // Each app keeps its logo in a slightly different place; take the first one that exists.
    $logo = collect(['images/logo.png', 'logo.svg', 'logo.png'])
        ->first(fn ($path) => file_exists(public_path($path)));

    $background = file_exists(public_path('images/login-bg.jpg')) ? 'images/login-bg.jpg' : null;
    $build = \Frietzakje\Ui\BuildStamp::current();
@endphp

<!DOCTYPE html>
<html lang="nl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1b1b1e">
    <title>{{ $code }} · {{ config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700&family=Nunito:wght@300;400;500;600;700;800;900&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-dvh bg-bg text-text antialiased">
    @if ($background)
        {{-- Same photo as the sign-in screen, under a strong scrim so the message stays legible. --}}
        <div class="fixed inset-0 bg-cover bg-center" style="background-image: url('{{ asset($background) }}');"></div>
        <div class="fixed inset-0 bg-bg/85"></div>
    @endif

    <main class="relative z-10 flex min-h-dvh flex-col items-center justify-center px-6 py-12 text-center">
        @if ($logo)
            <img src="{{ asset($logo) }}" alt="{{ config('app.name') }}" class="mb-6 h-20 w-auto opacity-90">
        @endif

        <p class="font-display text-7xl font-bold leading-none text-primary sm:text-8xl">{{ $code }}</p>

        <h1 class="mt-5 font-display text-2xl font-bold sm:text-3xl">{{ $title }}</h1>

        <p class="mt-3 max-w-md text-text/70">{{ $message }}</p>

        @if ($detail)
            {{-- What the app itself said about this refusal, when it wrote it for a human. --}}
            <p class="mt-3 max-w-md rounded-md border border-secondary/60 bg-secondary/20 px-4 py-2 text-sm text-text/60">{{ $detail }}</p>
        @endif

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            @if ($slot->isNotEmpty())
                {{ $slot }}
            @else
                <a href="{{ $homeUrl }}"
                   class="rounded-md bg-primary px-5 py-2.5 text-sm font-semibold text-bg transition-colors hover:bg-primary/90">
                    {{ $homeLabel }}
                </a>
            @endif
        </div>

        @if ($build !== '')
            <div class="pointer-events-none fixed bottom-2 right-3 font-mono text-[10px] leading-none text-white/20">{{ $build }}</div>
        @endif
    </main>
</body>
</html>
