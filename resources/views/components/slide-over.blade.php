{{-- A right-hand drawer for detail panels and filter forms — the thing you reach for when
     a modal would be too small and a new page too much. Open with
     $dispatch('open-slide-over', 'employee-detail'). --}}
<div
    x-data="{ open: false }"
    x-show="open"
    x-cloak
    x-on:open-slide-over.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-slide-over.window="if (! $event.detail || $event.detail === '{{ $name }}') open = false"
    x-on:keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex justify-end"
    role="dialog"
    aria-modal="true"
>
    <div
        x-show="open"
        @click="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-bg/80 backdrop-blur-sm"
    ></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        {{ $attributes->class('relative flex h-full w-full '.$width.' flex-col border-l border-secondary bg-bg shadow-panel') }}
    >
        <header class="flex items-start justify-between gap-3 border-b border-secondary p-5">
            <div class="min-w-0 space-y-1">
                @if ($title)
                    <h2 class="text-h3! truncate">{{ $title }}</h2>
                @endif
                @if ($description)
                    <p class="text-text/60"><small>{{ $description }}</small></p>
                @endif
            </div>

            <button
                type="button"
                @click="open = false"
                class="rounded p-1 text-text/70 transition-colors duration-150 hover:bg-secondary/40 hover:text-primary"
                aria-label="Close"
            >
                <x-frietzakje-icon name="close" class="text-xl" />
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-5">
            {{ $slot }}
        </div>

        @isset($footer)
            <footer class="flex justify-end gap-2 border-t border-secondary p-5">
                {{ $footer }}
            </footer>
        @endisset
    </div>
</div>
