<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1b1b1e">
    <title>{{ $title ?? config('app.name') }}</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('logo-64.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo-256.png') }}">

    {{-- PWA --}}
    @if(file_exists(public_path('manifest.webmanifest')))
        <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    @endif

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700&family=Nunito:wght@300;400;500;600;700;800;900&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,300..700,0..1,-50..200&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if(class_exists('Livewire\Livewire'))
        @livewireStyles
    @endif

    {{ $head ?? '' }}
</head>
<body class="flex min-h-screen flex-col bg-bg text-text antialiased"
      x-data="{ sidebarOpen: false }"
      :class="{ 'privacy': $store.discreet?.on }">

    {{-- Sidebar Layout --}}
        <div class="flex flex-1 overflow-hidden">
            {{-- Sidebar --}}
            <aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-shrink-0 flex-col border-r border-secondary bg-bg transition-transform duration-200 lg:static lg:h-screen overflow-y-auto"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

                {{-- Sidebar Header --}}
                <div class="flex h-16 items-center gap-2.5 border-b border-secondary px-4 flex-shrink-0">
                    @if(file_exists(public_path('logo.svg')))
                        <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}" class="h-9 w-9 rounded-md" loading="lazy">
                    @endif
                    <span class="text-h4 font-display font-extrabold">{{ config('app.name') }}</span>

                    {{-- Optional: Discretion Mode Toggle --}}
                    @if(isset($showDiscreetToggle) && $showDiscreetToggle)
                        <button type="button"
                                @click="$store.discreet.on = !$store.discreet.on"
                                class="ml-auto grid size-9 place-items-center rounded-md text-text/70 transition-colors hover:bg-secondary/40 hover:text-primary"
                                x-bind:aria-label="$store.discreet.on ? 'Bedragen tonen' : 'Bedragen verbergen'">
                            <x-frietzakje-icon name="visibility_off" class="text-xl" x-show="$store.discreet.on" />
                            <x-frietzakje-icon name="visibility" class="text-xl" x-show="!$store.discreet.on" />
                        </button>
                    @endif
                </div>

                {{-- Sidebar Navigation --}}
                <nav class="flex-1 p-4" aria-label="Main navigation">
                    {{ $navigation ?? '' }}
                </nav>

                {{-- Sidebar Footer (Optional User Menu) --}}
                @if(isset($userMenu))
                    <div class="border-t border-secondary p-4 flex-shrink-0">
                        {{ $userMenu }}
                    </div>
                @endif
            </aside>

            {{-- Mobile Overlay --}}
            <div x-show="sidebarOpen"
                 x-cloak
                 @click="sidebarOpen = false"
                 x-transition:enter="transition-opacity ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-30 bg-bg/80 backdrop-blur-sm lg:hidden"></div>

            {{-- Main Content Wrapper --}}
            <div class="flex flex-1 flex-col min-w-0">
                {{-- Mobile Top Bar --}}
                <header class="flex h-16 items-center gap-4 border-b border-secondary bg-bg px-4 lg:hidden flex-shrink-0">
                    <button type="button"
                            @click="sidebarOpen = !sidebarOpen"
                            class="grid size-9 place-items-center rounded-md transition-colors hover:bg-secondary/40">
                        <x-frietzakje-icon name="menu" class="text-2xl" />
                    </button>
                    <span class="text-lg font-bold">{{ config('app.name') }}</span>

                    {{-- Mobile Discretion Toggle --}}
                    @if(isset($showDiscreetToggle) && $showDiscreetToggle)
                        <button type="button"
                                @click="$store.discreet.on = !$store.discreet.on"
                                class="ml-auto grid size-9 place-items-center rounded-md text-text/70 transition-colors hover:bg-secondary/40 hover:text-primary">
                            <x-frietzakje-icon name="visibility_off" class="text-xl" x-show="$store.discreet.on" />
                            <x-frietzakje-icon name="visibility" class="text-xl" x-show="!$store.discreet.on" />
                        </button>
                    @endif
                </header>

                {{-- Main Content Area --}}
                <main class="flex-1 overflow-y-auto">
                    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

    {{-- Footer --}}
    @if(isset($showFooter) && $showFooter)
        <footer class="border-t border-secondary/60 bg-bg flex-shrink-0">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 text-xs text-text/50 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <span>&copy; {{ now()->year }} {{ config('app.name') }}. Alle rechten voorbehouden.</span>
                        @if(config('app.version'))
                            <span class="font-mono text-text/40">v{{ config('app.version') }}</span>
                        @endif
                    </div>
                    {{ $footerLinks ?? '' }}
                </div>
            </div>
        </footer>
    @endif

    {{-- Alpine Store for Discretion Mode --}}
    <script>
        document.addEventListener('alpine:init', () => {
            if (!Alpine.store('discreet')) {
                Alpine.store('discreet', { on: true });
            }
        });
    </script>

    @if(class_exists('Livewire\Livewire'))
        @livewireScripts
    @endif

    {{ $scripts ?? '' }}
</body>
</html>
