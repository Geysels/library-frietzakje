{{-- Modal driven by a Livewire boolean property. Backdrop blurs, content scales in.
     Closes on backdrop click, ESC, or the Sluiten button. --}}
<div
    x-data
    x-show="$wire.{{ $show }}"
    x-on:keydown.escape.window="$wire.{{ $closeMethod }}()"
    x-cloak
    class="fixed inset-0 z-50 grid place-items-center bg-bg/80 p-4 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div
        x-on:click.outside="$wire.{{ $closeMethod }}()"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        {{ $attributes->class('w-full '.$maxWidth.' rounded-lg border border-secondary bg-bg p-6 shadow-2xl') }}
    >
        @if ($title)
            <header class="mb-4 flex items-baseline justify-between gap-2">
                <h2 class="!text-h3">{{ $title }}</h2>
                <button type="button" wire:click="{{ $closeMethod }}" class="rounded p-1 text-text/70 transition-colors duration-150 hover:bg-secondary/40 hover:text-primary" aria-label="Sluiten">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </header>
        @endif

        {{ $slot }}
    </div>
</div>
