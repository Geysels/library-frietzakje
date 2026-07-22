<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1b1b1e">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>

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

          notifications: @js(collect($notifications ?? ($platformNotifications ?? []))->map(fn ($n) => $n + ['read' => $n['read'] ?? false])->values()),

          get unreadCount() {
              return this.notifications.filter(n => !n.read).length;
          },
          markAsRead(id) {
              const notif = this.notifications.find(n => n.id === id);
              if (notif) notif.read = true;
              this.persist('POST', '/notifications/' + id + '/read', id);
          },
          markAllAsRead() {
              this.notifications.forEach(n => n.read = true);
              this.persist('POST', '/notifications/read-all');
          },
          removeNotification(id) {
              this.notifications = this.notifications.filter(n => n.id !== id);
              this.persist('DELETE', '/notifications/' + id, id);
          },
          clearAll() {
              this.notifications = [];
              this.notificationPanelOpen = false;
              this.persist('DELETE', '/notifications');
          },

          persist(method, path, id = null) {
              if (id !== null && ! /^\d+$/.test(String(id))) return;
              fetch(path, {
                  method,
                  headers: {
                      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '',
                      'X-Requested-With': 'XMLHttpRequest',
                      'Accept': 'application/json',
                  },
              }).catch(() => {});
          },

          pushNotification(detail) {
              detail = detail || {};
              this.notifications.unshift({
                  id: detail.id ?? ('n' + Date.now() + '-' + Math.floor(Math.random() * 1e6)),
                  type: detail.type ?? 'neutral',
                  icon: detail.icon ?? 'notifications',
                  title: detail.title ?? 'Notificatie',
                  message: detail.message ?? '',
                  time: detail.time ?? 'nu',
                  url: detail.url ?? null,
                  read: false,
              });
              if (detail.open) this.notificationPanelOpen = true;
          }
      }"
      @notify.window="pushNotification($event.detail)"
      :class="{ 'privacy': $store.discreet?.on }">

    @include('frietzakje::partials.page-loader')

    <nav class="sticky top-0 z-50 h-16 flex-shrink-0 border-b border-secondary bg-bg/95 backdrop-blur-sm">
        <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden grid size-9 place-items-center rounded-md hover:bg-secondary/40 transition-colors" :aria-expanded="sidebarOpen" aria-label="Menu">
                    <x-frietzakje-icon name="menu" class="text-2xl" x-show="!sidebarOpen" />
                    <x-frietzakje-icon name="close" class="text-2xl" x-show="sidebarOpen" x-cloak />
                </button>

                <div class="flex items-center gap-2.5">
                    @if(file_exists(public_path('logo.svg')))
                        <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}" class="h-8 w-8 rounded-md">
                    @endif
                    <h1 class="wordmark text-primary text-xl hidden sm:inline">{{ config('frietzakje-ui.brand') }}</h1>
                </div>

                @if(isset($badge))
                    {{ $badge }}
                @endif
            </div>

            <div class="flex items-center gap-2">
                <x-frietzakje-app-switcher align="right" />

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

                    <div
                        x-show="notificationPanelOpen"
                        @click.outside="notificationPanelOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="fixed inset-x-2 top-[4.25rem] w-auto rounded-lg border border-secondary bg-bg shadow-panel sm:absolute sm:inset-x-auto sm:right-0 sm:top-12 sm:w-96"
                        x-cloak
                    >
                        <div class="flex items-center justify-between border-b border-secondary p-4">
                            <div>
                                <h3 class="font-bold">Notificaties</h3>
                                <p class="text-xs text-text/60" x-text="unreadCount > 0 ? unreadCount + ' ongelezen' : 'Alles gelezen'"></p>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    @click="markAllAsRead()"
                                    class="text-xs text-primary hover:underline"
                                    x-show="unreadCount > 0"
                                >
                                    Alles gelezen markeren
                                </button>
                                <button
                                    @click="clearAll()"
                                    class="text-xs text-danger hover:underline"
                                    x-show="notifications.length > 0"
                                >
                                    Alles wissen
                                </button>
                            </div>
                        </div>

                        <div class="max-h-96 overflow-y-auto">
                            <template x-if="notifications.length === 0">
                                <div class="p-8 text-center">
                                    <x-frietzakje-icon name="notifications_none" class="text-4xl text-text/40 mx-auto mb-2" />
                                    <p class="text-sm text-text/60">Geen notificaties</p>
                                </div>
                            </template>

                            <template x-for="notification in notifications" :key="notification.id">
                                <a
                                    :href="notification.url || '#'"
                                    class="block border-b border-secondary/40 p-4 hover:bg-secondary/20 transition-colors cursor-pointer relative group"
                                    :class="{ 'bg-secondary/10': !notification.read }"
                                    @click="markAsRead(notification.id)"
                                >
                                    <div
                                        x-show="!notification.read"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-primary"
                                    ></div>

                                    <div class="flex gap-3 pl-4">
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

                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold" x-text="notification.title"></p>
                                            <p class="text-xs text-text/70 mt-1" x-text="notification.message"></p>
                                            <p class="text-xs text-text/50 mt-2" x-text="notification.time"></p>
                                        </div>

                                        <button
                                            type="button"
                                            @click.stop.prevent="removeNotification(notification.id)"
                                            class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity"
                                            aria-label="Notificatie verwijderen"
                                        >
                                            <x-frietzakje-icon name="close" class="text-lg text-text/60 hover:text-danger" />
                                        </button>
                                    </div>
                                </a>
                            </template>
                        </div>

                        @if(\Illuminate\Support\Facades\Route::has('notifications'))
                        <div class="border-t border-secondary p-3 text-center">
                            <a href="{{ route('notifications') }}" class="text-sm text-primary hover:underline">Alle notificaties bekijken</a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @php
                    $__showDiscreet = ($showDiscreetToggle ?? false)
                        || (auth()->check() && method_exists(auth()->user(), 'isOwner') && auth()->user()->isOwner());
                @endphp
                @if($__showDiscreet)
                <button type="button"
                        @click="$store.discreet.on = !$store.discreet.on"
                        class="hidden size-9 place-items-center rounded-md text-text/70 transition-colors hover:bg-secondary/40 hover:text-primary sm:grid"
                        x-bind:aria-label="$store.discreet.on ? 'Gevoelige gegevens tonen' : 'Gevoelige gegevens verbergen'"
                        x-bind:title="$store.discreet.on ? 'Gevoelige gegevens tonen' : 'Gevoelige gegevens verbergen'">
                    <x-frietzakje-icon name="visibility_off" class="text-xl" x-show="$store.discreet.on" />
                    <x-frietzakje-icon name="visibility" class="text-xl" x-show="!$store.discreet.on" />
                </button>
                @endif

                @if(isset($topActions))
                    {{ $topActions }}
                @endif

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

                    <div
                        x-show="userMenuOpen"
                        @click.outside="userMenuOpen = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-4 top-14 w-56 rounded-lg border border-secondary bg-bg shadow-panel"
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
                                class="absolute right-4 top-14 w-56 rounded-lg border border-secondary bg-bg shadow-panel"
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
                                        @if($__showDiscreet)
                                            <button type="button"
                                                @click="$store.discreet.on = !$store.discreet.on"
                                                class="flex w-full items-center gap-3 px-3 py-2 text-left text-sm transition-colors hover:bg-secondary/40 sm:hidden">
                                                <x-frietzakje-icon name="visibility_off" class="text-lg" x-show="$store.discreet.on" />
                                                <x-frietzakje-icon name="visibility" class="text-lg" x-show="!$store.discreet.on" x-cloak />
                                                <span x-text="$store.discreet.on ? 'Gevoelige gegevens tonen' : 'Gevoelige gegevens verbergen'"></span>
                                            </button>
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

    <div class="flex flex-1 lg:min-h-0">
        <aside class="fixed top-16 bottom-0 left-0 z-40 w-full flex-shrink-0 overflow-y-auto border-r border-secondary bg-bg transition-transform duration-200 lg:static lg:w-64"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

            <nav class="flex-1 p-4" aria-label="Main navigation">
                @isset($navigation)
                    {{ $navigation }}
                @elseif(config('frietzakje-ui.nav'))
                    <x-frietzakje::nav :sections="config('frietzakje-ui.nav')" />
                @endif
            </nav>

            @if(isset($sidebarFooter))
                <div class="border-t border-secondary p-4 flex-shrink-0">
                    {{ $sidebarFooter }}
                </div>
            @endif
        </aside>

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

    @if($showFooter ?? true)
        <footer class="flex-shrink-0 border-t border-secondary/60 bg-bg">
            <div class="w-full px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-3 text-xs text-text/50 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                        <span>&copy; {{ now()->year }} {{ config('frietzakje-ui.brand') }}. Alle rechten voorbehouden.</span>
                        @php($buildStamp = \Frietzakje\Ui\BuildStamp::current())
                        @if($buildStamp !== '')
                            <span class="font-mono text-text/40">{{ $buildStamp }}</span>
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

    @include('frietzakje::partials.cookie-banner')

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
