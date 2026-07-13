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
<body class="min-h-screen bg-bg text-text antialiased"
      x-data="{
          sidebarOpen: false,
          notificationCount: {{ $notificationCount ?? 0 }},
          messageCount: {{ $messageCount ?? 0 }}
      }"
      :class="{ 'privacy': $store.discreet?.on }">

    {{-- Top Navigation Bar --}}
    <nav class="sticky top-0 z-50 border-b border-secondary bg-bg/95 backdrop-blur-sm">
        <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6">
            {{-- Left Section --}}
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden grid size-9 place-items-center rounded-md hover:bg-secondary/40 transition-colors">
                    <x-frietzakje-icon name="menu" class="text-2xl" />
                </button>

                <div class="flex items-center gap-2.5">
                    @if(file_exists(public_path('logo.svg')))
                        <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}" class="h-8 w-8 rounded-md">
                    @endif
                    <h1 class="text-primary text-xl font-display font-bold hidden sm:inline">{{ config('app.name') }}</h1>
                </div>

                @if(isset($badge))
                    {{ $badge }}
                @endif
            </div>

            {{-- Right Section --}}
            <div class="flex items-center gap-2">
                {{-- Search --}}
                @if(!isset($hideSearch) || !$hideSearch)
                <button class="hidden sm:grid size-9 place-items-center rounded-md hover:bg-secondary/40 transition-colors">
                    <x-frietzakje-icon name="search" class="text-xl" />
                </button>
                @endif

                {{-- Notifications with Badge --}}
                @if(!isset($hideNotifications) || !$hideNotifications)
                <div class="relative">
                    <button
                        class="grid size-9 place-items-center rounded-md hover:bg-secondary/40 transition-colors"
                        @click="$dispatch('toast', {message: notificationCount > 0 ? 'You have ' + notificationCount + ' new notifications' : 'No new notifications', variant: 'message'})"
                    >
                        <x-frietzakje-icon name="notifications" class="text-xl" />
                    </button>
                    <span
                        x-show="notificationCount > 0"
                        x-text="notificationCount"
                        x-cloak
                        class="absolute -top-1 -right-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-danger px-1 text-xs font-bold text-bg"
                    ></span>
                </div>
                @endif

                {{-- Messages --}}
                @if(!isset($hideMessages) || !$hideMessages)
                <div class="relative hidden md:block">
                    <button class="grid size-9 place-items-center rounded-md hover:bg-secondary/40 transition-colors">
                        <x-frietzakje-icon name="mail" class="text-xl" />
                    </button>
                    <span
                        x-show="messageCount > 0"
                        x-text="messageCount"
                        x-cloak
                        class="absolute -top-1 -right-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-primary px-1 text-xs font-bold text-bg"
                    ></span>
                </div>
                @endif

                {{-- Discretion Mode Toggle --}}
                @if(isset($showDiscreetToggle) && $showDiscreetToggle)
                <button type="button"
                        @click="$store.discreet.on = !$store.discreet.on"
                        class="hidden md:grid size-9 place-items-center rounded-md text-text/70 transition-colors hover:bg-secondary/40 hover:text-primary"
                        x-bind:aria-label="$store.discreet.on ? 'Show amounts' : 'Hide amounts'">
                    <x-frietzakje-icon name="visibility_off" class="text-xl" x-show="$store.discreet.on" />
                    <x-frietzakje-icon name="visibility" class="text-xl" x-show="!$store.discreet.on" />
                </button>
                @endif

                {{-- Custom Top Actions --}}
                @if(isset($topActions))
                    {{ $topActions }}
                @endif

                {{-- User Menu --}}
                @if(isset($userName) || isset($topUserMenu))
                <div class="flex items-center gap-2 ml-2 pl-2 border-l border-secondary" x-data="{ userMenuOpen: false }">
                    <button
                        @click="userMenuOpen = !userMenuOpen"
                        class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-secondary/40 transition-colors"
                    >
                        <x-frietzakje-avatar size="sm" />
                        @if(isset($userName))
                            <span class="text-sm font-medium hidden md:inline">{{ $userName }}</span>
                        @endif
                        <x-frietzakje-icon name="expand_more" class="text-lg" />
                    </button>

                    {{-- User Dropdown --}}
                    <div
                        x-show="userMenuOpen"
                        @click.outside="userMenuOpen = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-4 top-14 w-56 rounded-lg border border-secondary bg-bg shadow-xl"
                        x-cloak
                    >
                        @if(isset($topUserMenu))
                            {{ $topUserMenu }}
                        @else
                            <div class="p-3 border-b border-secondary">
                                <p class="font-semibold">{{ $userName ?? 'User' }}</p>
                                @if(isset($userEmail))
                                    <p class="text-xs text-text/60">{{ $userEmail }}</p>
                                @endif
                            </div>
                            <div class="py-2">
                                <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm hover:bg-secondary/40 transition-colors">
                                    <x-frietzakje-icon name="person" class="text-lg" />
                                    Profile
                                </a>
                                <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm hover:bg-secondary/40 transition-colors">
                                    <x-frietzakje-icon name="settings" class="text-lg" />
                                    Settings
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </nav>

    {{-- Main Layout --}}
    <div class="flex min-h-[calc(100vh-4rem)]">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-16 left-0 z-40 w-64 flex-shrink-0 border-r border-secondary bg-bg transition-transform duration-200 lg:static lg:inset-y-0 overflow-y-auto"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

            {{-- Sidebar Navigation --}}
            <nav class="flex-1 p-4" aria-label="Main navigation">
                {{ $navigation ?? '' }}
            </nav>

            {{-- Sidebar Footer (Optional User Menu) --}}
            @if(isset($sidebarFooter))
                <div class="border-t border-secondary p-4 flex-shrink-0">
                    {{ $sidebarFooter }}
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

        {{-- Main Content --}}
        <main class="flex-1 min-w-0 overflow-x-hidden overflow-y-auto">
            <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
                {{ $slot }}
            </div>
        </main>
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
