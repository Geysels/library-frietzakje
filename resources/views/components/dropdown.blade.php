@php
    // Anchor the menu to the trigger: left-aligned grows from the trigger's bottom-start,
    // right-aligned from bottom-end. Small offset so it sits just under the trigger.
    $anchor = 'x-anchor.'.($align === 'left' ? 'bottom-start' : 'bottom-end').'.offset.6';
@endphp

<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    {{ $attributes->class('relative inline-block text-left') }}
>
    <div x-ref="trigger" @click="open = ! open">
        {{ $trigger }}
    </div>

    {{-- Teleported to <body>, so no ancestor's overflow can clip it — a scrolling <main>, a
         table with overflow-x-auto, a card clipped to its radius. `x-anchor` keeps it pinned
         to the trigger (and repositions on scroll/resize), so it still opens in the right place. --}}
    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            {{ $anchor }}="$refs.trigger"
            @click.outside="open = false"
            @click="open = false"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="z-50 {{ $width }} rounded-lg border border-secondary bg-bg p-1 shadow-panel"
            role="menu"
        >
            {{ $slot }}
        </div>
    </template>
</div>
