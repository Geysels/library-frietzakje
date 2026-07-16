<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1b1b1e">
    <title>{{ $title ?? config('app.name') }}</title>

    {{-- Favicons + web app manifest (realfavicongenerator.net set, served from public root). --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    @if(file_exists(public_path('site.webmanifest')))
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    @endif

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700&family=Roboto+Slab:wght@400;500;700&family=Nunito:wght@300;400;500;600;700;800;900&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,300..700,0..1,-50..200&display=block" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if(class_exists('Livewire\Livewire'))
        @livewireStyles
    @endif

    {{ $head ?? '' }}
</head>
<body class="flex min-h-dvh flex-col bg-bg text-text antialiased lg:h-dvh lg:overflow-hidden"
      x-data="{
          sidebarOpen: false,
          messageCount: {{ $messageCount ?? 0 }},
          notificationPanelOpen: false,

          {{-- The list is a prop, not a hardcoded fixture. It used to ship three invented
               notifications ('Deployment successful', 'High memory usage') baked into the
               layout, which meant no application could ever put a real one there — so pages
               grew their own alert banners instead and said everything twice.

               Each notification: { id, type, icon, title, message, time, url?, read? }
               `type` is any palette variant; `url` makes the row a link to the thing it is
               telling you about. --}}
          notifications: @js(collect($notifications ?? [])->map(fn ($n) => $n + ['read' => $n['read'] ?? false])->values()),

          {{-- The badge reads this getter, so the count is derived from the list and cannot
               drift out of step with it. The old code also kept a separate `notificationCount`
               and hand-assigned it in four places — a second source of truth for the same
               number, which is exactly how a bell ends up claiming 3 unread over an empty
               panel. --}}
          get unreadCount() {
              return this.notifications.filter(n => !n.read).length;
          },
          markAsRead(id) {
              const notif = this.notifications.find(n => n.id === id);
              if (notif) notif.read = true;
          },
          markAllAsRead() {
              this.notifications.forEach(n => n.read = true);
          },
          removeNotification(id) {
              this.notifications = this.notifications.filter(n => n.id !== id);
          },
          clearAll() {
              this.notifications = [];
              this.notificationPanelOpen = false;
          }
      }"
      :class="{ 'privacy': $store.discreet?.on }">

    @include('frietzakje::partials.page-loader')

    {{-- Top Navigation Bar. The whole layout is an app shell: <body> is a fixed-height
         (h-dvh) flex column that never scrolls, so this bar — a flex-shrink-0 row at the top —
         is always on screen without `fixed`/`sticky` (both of which the app.css
         `overflow-x: hidden` on html/body would fight). Only <main> scrolls. --}}
    <nav class="sticky top-0 z-50 h-16 flex-shrink-0 border-b border-secondary bg-bg/95 backdrop-blur-sm">
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
                    <h1 class="wordmark text-primary text-xl hidden sm:inline">{{ config('app.name') }}</h1>
                </div>

                @if(isset($badge))
                    {{ $badge }}
                @endif
            </div>

            {{-- Right Section --}}
            <div class="flex items-center gap-2">
                {{-- The suite launcher. Each app in the ecosystem is its own deployment, so
                     this is the only thing that lets a user move between them — and the only
                     reason several separate apps read as one product. It renders nothing when
                     there is nowhere to switch to. Opens right-aligned so the panel stays
                     on-screen from this edge. --}}
                <x-frietzakje-app-switcher align="right" />

                {{-- Notifications with Badge & Dropdown --}}
                @if(!isset($hideNotifications) || !$hideNotifications)
                <div class="relative">
                    <button
                        class="grid size-9 place-items-center rounded-md hover:bg-secondary/40 transition-colors"
                        @click="notificationPanelOpen = !notificationPanelOpen"
                        :class="{ 'bg-secondary/40': notificationPanelOpen }"
                    >
                        <x-frietzakje-icon name="notifications" class="text-xl" />
                    </button>
                    <span
                        x-show="unreadCount > 0"
                        x-text="unreadCount"
                        x-cloak
                        class="absolute -top-1 -right-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-danger px-1 text-xs font-bold text-bg"
                    ></span>

                    {{-- Notification Dropdown Panel --}}
                    <div
                        x-show="notificationPanelOpen"
                        @click.outside="notificationPanelOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="fixed inset-x-2 top-[4.25rem] w-auto rounded-lg border border-secondary bg-bg shadow-2xl sm:absolute sm:inset-x-auto sm:right-0 sm:top-12 sm:w-96"
                        x-cloak
                    >
                        {{-- Header --}}
                        <div class="flex items-center justify-between border-b border-secondary p-4">
                            <div>
                                <h3 class="font-bold">Notifications</h3>
                                <p class="text-xs text-text/60" x-text="unreadCount > 0 ? unreadCount + ' unread' : 'All caught up!'"></p>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    @click="markAllAsRead()"
                                    class="text-xs text-primary hover:underline"
                                    x-show="unreadCount > 0"
                                >
                                    Mark all read
                                </button>
                                <button
                                    @click="clearAll()"
                                    class="text-xs text-danger hover:underline"
                                    x-show="notifications.length > 0"
                                >
                                    Clear all
                                </button>
                            </div>
                        </div>

                        {{-- Notifications List --}}
                        <div class="max-h-96 overflow-y-auto">
                            <template x-if="notifications.length === 0">
                                <div class="p-8 text-center">
                                    <x-frietzakje-icon name="notifications_none" class="text-4xl text-text/40 mx-auto mb-2" />
                                    <p class="text-sm text-text/60">No notifications</p>
                                </div>
                            </template>

                            <template x-for="notification in notifications" :key="notification.id">
                                {{-- A notification that tells you something is wrong but gives you
                                     nowhere to go is just an interruption, so the row is a link
                                     whenever the caller supplies a `url`. --}}
                                <a
                                    :href="notification.url || '#'"
                                    class="block border-b border-secondary/40 p-4 hover:bg-secondary/20 transition-colors cursor-pointer relative group"
                                    :class="{ 'bg-secondary/10': !notification.read }"
                                    @click="markAsRead(notification.id)"
                                >
                                    {{-- Unread indicator --}}
                                    <div
                                        x-show="!notification.read"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-primary"
                                    ></div>

                                    <div class="flex gap-3 pl-4">
                                        {{-- Icon. `warning` has its own colour now — it used to be
                                             lumped in with danger, so "expiring soon" and "already
                                             broken" shouted at exactly the same volume. --}}
                                        <div class="flex-shrink-0">
                                            <div
                                                class="size-10 rounded-full flex items-center justify-center"
                                                :class="{
                                                    'bg-secondary/60 text-text/70': ! notification.type || notification.type === 'neutral',
                                                    'bg-success/20 text-success': notification.type === 'success',
                                                    'bg-warning/20 text-warning': notification.type === 'warning',
                                                    'bg-danger/20 text-danger': notification.type === 'danger',
                                                    'bg-primary/20 text-primary': notification.type === 'primary',
                                                    'bg-message/20 text-message': notification.type === 'message' || notification.type === 'info',
                                                    'bg-accent-2/20 text-accent-2': notification.type === 'accent-2'
                                                }"
                                            >
                                                <span class="material-symbols-outlined text-xl" x-text="notification.icon"></span>
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold" x-text="notification.title"></p>
                                            <p class="text-xs text-text/70 mt-1" x-text="notification.message"></p>
                                            <p class="text-xs text-text/50 mt-2" x-text="notification.time"></p>
                                        </div>

                                        {{-- Dismiss button --}}
                                        <button
                                            type="button"
                                            @click.stop.prevent="removeNotification(notification.id)"
                                            class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity"
                                            aria-label="Dismiss notification"
                                        >
                                            <x-frietzakje-icon name="close" class="text-lg text-text/60 hover:text-danger" />
                                        </button>
                                    </div>
                                </a>
                            </template>
                        </div>

                        {{-- Footer --}}
                        <div class="border-t border-secondary p-3 text-center">
                            <a href="#" class="text-sm text-primary hover:underline">View all notifications</a>
                        </div>
                    </div>
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
                @else
                    {{-- No explicit user slot was passed, so fall back to the app's auth
                         state. A signed-in user gets their initials and a menu with sign
                         out; a guest gets a login icon that goes to the login page. The
                         links only render if the app actually has those named routes, so
                         this stays inert in apps that have no auth. --}}
                    @auth
                        @php
                            $__u = auth()->user();
                            $__name = $__u->name ?? ($__u->username ?? 'Account');
                            $__initials = collect(explode(' ', trim($__name)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))
                                ->implode('');
                            $__initials = $__initials !== '' ? $__initials : mb_strtoupper(mb_substr($__name, 0, 2));
                        @endphp
                        <div class="flex items-center gap-2 ml-2 pl-2 border-l border-secondary" x-data="{ userMenuOpen: false }">
                            <button
                                @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-secondary/40 transition-colors"
                                :aria-expanded="userMenuOpen"
                                aria-label="{{ __('Account menu') }}"
                            >
                                <x-frietzakje-avatar size="sm" :fallback="$__initials" :alt="$__name" />
                                <span class="text-sm font-medium hidden md:inline">{{ $__name }}</span>
                                <x-frietzakje-icon name="expand_more" class="text-lg" />
                            </button>

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
                                <div class="p-3 border-b border-secondary">
                                    <p class="font-semibold truncate">{{ $__name }}</p>
                                    @if(!empty($__u->email))
                                        <p class="text-xs text-text/60 truncate">{{ $__u->email }}</p>
                                    @endif
                                </div>
                                @if(Route::has('profile') || Route::has('logout'))
                                    <div class="py-2">
                                        @if(Route::has('profile'))
                                            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3 py-2 text-sm hover:bg-secondary/40 transition-colors">
                                                <x-frietzakje-icon name="manage_accounts" class="text-lg" />
                                                {{ __('Profile') }}
                                            </a>
                                        @endif
                                        @if(Route::has('logout'))
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-left text-danger hover:bg-secondary/40 transition-colors">
                                                    <x-frietzakje-icon name="logout" class="text-lg" />
                                                    {{ __('Sign out') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        @if(Route::has('login'))
                            <a href="{{ route('login') }}"
                               class="ml-2 grid size-9 place-items-center rounded-md transition-colors hover:bg-secondary/40"
                               aria-label="{{ __('Sign in') }}"
                               title="{{ __('Sign in') }}">
                                <x-frietzakje-icon name="login" class="text-xl" />
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    {{-- Main Layout row (sidebar + content). `flex-1 min-h-0` fills the space between the
         navbar and footer; `min-h-0` is what lets <main>'s own scrollbar work inside a flex
         parent instead of the row growing to fit all the content. --}}
    <div class="flex flex-1 lg:min-h-0">
        {{-- Sidebar --}}
        <aside class="fixed top-16 bottom-0 left-0 z-40 w-64 flex-shrink-0 overflow-y-auto border-r border-secondary bg-bg transition-transform duration-200 lg:static"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

            {{-- Sidebar Navigation. A page may pass its own `navigation` slot; otherwise the
                 app's nav data (config('frietzakje-ui.nav'), set per app) is rendered by the
                 shared component — one layout, identical menu across apps, entries per app. --}}
            <nav class="flex-1 p-4" aria-label="Main navigation">
                @isset($navigation)
                    {{ $navigation }}
                @elseif(config('frietzakje-ui.nav'))
                    <x-frietzakje::sidebar-nav :sections="config('frietzakje-ui.nav')" />
                @endif
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

        {{-- Main Content.

             Content fills the width. An app screen is not an article: the sidebar already takes
             256px, and centring what is left inside a max-w-7xl column buys empty gutters at the
             cost of the table you were trying to read. A page that genuinely wants to be narrow
             (a wizard, a settings form) constrains itself — that is a decision for the page to
             make, not a tax on every page.

             `fluid` additionally drops the padding, for screens that must reach the edges: the
             split-view inbox, the kanban board, the planner grid.

             <main> IS the scroll container here (`overflow-y-auto`): in this app shell the window
             never scrolls — the navbar, sidebar and footer are fixed-size rows of a
             viewport-height body, and only the content in here moves. Any in-page sticky
             (save bars, table headers) now sticks relative to <main>, which is what we want. --}}
        <main class="min-w-0 flex-1 overflow-x-hidden lg:overflow-y-auto">
            @if ($fluid ?? false)
                <div class="w-full">
                    {{ $slot }}
                </div>
            @else
                <div class="w-full px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
                    {{ $slot }}
                </div>
            @endif
        </main>
    </div>

    {{-- Footer — shown by default (a page can opt out with :showFooter="false"). As the last
         flex-shrink-0 row of the viewport-height body, it is always on screen at the bottom
         while the content scrolls above it. Carries copyright, the build identity (version +
         commit — its one home now, not the navbar), and the legal links. --}}
    @if($showFooter ?? true)
        <footer class="flex-shrink-0 border-t border-secondary/60 bg-bg">
            <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 text-xs text-text/50 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                        <span>&copy; {{ now()->year }} {{ config('app.name') }}. Alle rechten voorbehouden.</span>
                        @if(config('app.version') || config('app.commit'))
                            <span class="font-mono text-text/40">{{ trim('v'.config('app.version').' · '.config('app.commit'), ' ·') }}</span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                        @if(\Illuminate\Support\Facades\Route::has('legal.company'))
                            <a href="{{ route('legal.company') }}" class="transition-colors hover:text-text">{{ __('Company details') }}</a>
                        @endif
                        @if(\Illuminate\Support\Facades\Route::has('legal.terms'))
                            <a href="{{ route('legal.terms') }}" class="transition-colors hover:text-text">{{ __('Terms of service') }}</a>
                        @endif
                        @if(\Illuminate\Support\Facades\Route::has('legal.privacy'))
                            <a href="{{ route('legal.privacy') }}" class="transition-colors hover:text-text">{{ __('Privacy policy') }}</a>
                        @endif
                        @if(\Illuminate\Support\Facades\Route::has('legal.cookies'))
                            <a href="{{ route('legal.cookies') }}" class="transition-colors hover:text-text">{{ __('Cookie policy') }}</a>
                        @endif
                        {{ $footerLinks ?? '' }}
                    </div>
                </div>
            </div>
        </footer>
    @endif

    {{-- Cookie consent — asks once, remembers the choice. --}}
    @include('frietzakje::partials.cookie-banner')

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
