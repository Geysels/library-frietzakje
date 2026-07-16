{{-- Backdrop blurs, panel scales in. Closes on backdrop click, ESC, or the close button.
     Driven either by Alpine events (`name`) or a Livewire boolean (`show`). --}}
@php
    // No border (it muddied the edge); a single soft shadow lifts the panel off the dark backdrop
    // without the banding that shadow-2xl showed. The OUTER div is the scroll container, so the
    // panel needs no height cap of its own — a modal taller than the screen grows the scroll area
    // and stays reachable, instead of being clipped at the bottom.
    $panelClasses = 'w-full '.$maxWidth.' rounded-xl bg-bg p-6 shadow-[0_20px_60px_-10px_rgba(0,0,0,0.55)]';
@endphp

<div
    @if ($usesLivewire())
        x-data
        x-show="$wire.{{ $show }}"
        x-effect="document.documentElement.classList.toggle('overflow-hidden', $wire.{{ $show }})"
        x-on:keydown.escape.window="$wire.{{ $closeMethod }}()"
    @else
        x-data="{ open: false }"
        x-show="open"
        {{-- Lock the page behind the modal so a phone scrolls the modal, not the page under it.
             Toggling on <html> is the reliable way to freeze the document scroll. --}}
        x-effect="document.documentElement.classList.toggle('overflow-hidden', open)"
        x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
        x-on:close-modal.window="if (! $event.detail || $event.detail === '{{ $name }}') open = false"
        x-on:keydown.escape.window="open = false"
    @endif
    x-cloak
    {{-- Backdrop AND scroll container: scrolling happens here, so a modal taller than the screen is
         fully reachable and never cut off by the viewport or the footer below the page. --}}
    class="fixed inset-0 z-50 overflow-y-auto bg-bg/80 p-4 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    role="dialog"
    aria-modal="true"
>
    {{-- Grows with the panel: centres a short modal, and lets a tall one scroll from the top. --}}
    <div class="flex min-h-full items-center justify-center">
        <div
            @if ($usesLivewire())
                x-on:click.outside="$wire.{{ $closeMethod }}()"
            @else
                x-on:click.outside="open = false"
            @endif
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            {{ $attributes->class($panelClasses) }}
        >
            @if ($title)
                <header class="mb-4 flex items-start justify-between gap-2">
                    <div class="space-y-1">
                        <h2 class="text-h3!">{{ $title }}</h2>
                        @if ($description)
                            <p class="text-text/60"><small>{{ $description }}</small></p>
                        @endif
                    </div>

                    <button
                        type="button"
                        @if ($usesLivewire()) wire:click="{{ $closeMethod }}" @else @click="open = false" @endif
                        class="rounded p-1 text-text/70 transition-colors duration-150 hover:bg-secondary/40 hover:text-primary"
                        aria-label="Close"
                    >
                        <x-frietzakje-icon name="close" class="text-xl" />
                    </button>
                </header>
            @endif

            {{ $slot }}

            @isset($footer)
                <footer class="mt-6 flex justify-end gap-2">
                    {{ $footer }}
                </footer>
            @endisset
        </div>
    </div>
</div>
