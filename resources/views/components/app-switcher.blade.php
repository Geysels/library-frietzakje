@php
    $current = $currentApp();
@endphp

<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    {{ $attributes->class('relative') }}
>
    <button
        type="button"
        @click="open = ! open"
        :class="{ 'bg-secondary/40': open }"
        class="flex items-center gap-2 rounded-md px-2 py-1.5 transition-colors hover:bg-secondary/40"
        aria-label="Switch application"
        :aria-expanded="open"
    >
        <x-frietzakje-icon name="grid_view" class="text-xl" />

        {{-- Naming the app you are in is half the point: with several deployments wearing the
             same shell, "which one am I looking at" stops being obvious. Always shown (icon +
             label); falls back to the app name if FRIETZAKJE_APP isn't set to a known app. --}}
        <span class="hidden font-display text-sm font-semibold sm:inline">{{ $current['name'] ?? config('app.name') }}</span>

        <x-frietzakje-icon name="expand_more" class="text-lg" />
    </button>

    <div
        x-show="open"
        x-cloak
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @class([
            'z-50 rounded-lg border border-secondary bg-bg p-2 shadow-panel',
            // Mobile: pinned just below the navbar, spanning the viewport with small gutters,
            // so it can never run off the edge no matter where the button sits.
            'fixed inset-x-2 top-[4.25rem] w-auto',
            // Desktop: anchored to the button.
            'sm:absolute sm:inset-x-auto sm:top-full sm:mt-2 sm:w-80',
            'sm:left-0 sm:origin-top-left' => $align !== 'right',
            'sm:right-0 sm:origin-top-right' => $align === 'right',
        ])
        role="menu"
    >
        <p class="px-2 pb-2 pt-1 text-xs font-semibold uppercase tracking-wider text-text/50">
            Frietzakje
        </p>

        <div class="space-y-0.5">
            @foreach ($apps as $app)
                {{-- Deliberately not named `$isCurrent`: that is the component method, and
                     shadowing it with a bool makes the next iteration try to call a boolean. --}}
                @php $here = $isCurrent($app); @endphp

                <a
                    href="{{ $app['url'] }}"
                    role="menuitem"
                    @if ($here) aria-current="true" @endif
                    @class([
                        'flex items-start gap-3 rounded-md p-2 transition-colors duration-150',
                        'bg-primary/10' => $here,
                        'hover:bg-secondary/50' => ! $here,
                    ])
                >
                    <div @class([
                        'grid size-9 flex-shrink-0 place-items-center rounded-lg',
                        'bg-primary/20 text-primary' => $here,
                        'bg-secondary/60 text-text/60' => ! $here,
                    ])>
                        <x-frietzakje-icon :name="$app['icon'] ?? 'apps'" class="text-xl" />
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <span @class([
                                'font-display text-sm font-semibold',
                                'text-primary' => $here,
                            ])>{{ $app['name'] }}</span>

                            @if ($here)
                                <x-frietzakje-badge variant="primary" size="sm">Huidig</x-frietzakje-badge>
                            @endif
                        </div>

                        @if (! empty($app['description']))
                            <p class="truncate text-xs text-text/60">{{ $app['description'] }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
