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
            'fixed inset-x-2 top-[4.25rem] w-auto',
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
            @php $__user = auth()->user(); @endphp
            @foreach ($apps as $app)
                {{-- Owner-only apps stay hidden from everyone else. --}}
                @continue(($app['owner'] ?? false) && ! ($__user?->isOwner()))
                @php
                    $here = $isCurrent($app);
                    $locked = $app['locked'] ?? false;
                @endphp

                @if ($locked)
                    {{-- Coming soon: shown so people know it's on the way, but not yet openable. --}}
                    <div aria-disabled="true" class="flex items-start gap-3 rounded-md p-2 opacity-60">
                        <div class="grid size-9 flex-shrink-0 place-items-center rounded-lg bg-secondary/60 text-text/50">
                            <x-frietzakje-icon :name="$app['icon'] ?? 'apps'" class="text-xl" />
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-display text-sm font-semibold text-text/70">{{ $app['name'] }}</span>
                                <x-frietzakje-badge variant="neutral" size="sm">Binnenkort</x-frietzakje-badge>
                            </div>

                            @if (! empty($app['description']))
                                <p class="truncate text-xs text-text/60">{{ $app['description'] }}</p>
                            @endif
                        </div>

                        <x-frietzakje-icon name="lock" class="mt-1 flex-shrink-0 text-base text-text/40" />
                    </div>
                @else
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
                @endif
            @endforeach
        </div>
    </div>
</div>
