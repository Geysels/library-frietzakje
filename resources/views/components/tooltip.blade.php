@php
    // x-anchor pins the teleported bubble to the trigger for each side (centred on that edge).
    $anchors = [
        'top' => 'x-anchor.top.offset.8',
        'bottom' => 'x-anchor.bottom.offset.8',
        'left' => 'x-anchor.left.offset.8',
        'right' => 'x-anchor.right.offset.8',
    ];
    $anchor = $anchors[$position] ?? $anchors['top'];
@endphp

<span
    x-data="{ show: false }"
    @mouseenter="show = true"
    @mouseleave="show = false"
    @focusin="show = true"
    @focusout="show = false"
    {{ $attributes->class('relative inline-flex') }}
>
    <span x-ref="trigger" class="inline-flex">{{ $slot }}</span>

    {{-- Teleported to <body>, so no ancestor's overflow can clip it — a card clipped to its radius,
         a scrolling panel, a table with overflow-x-auto. `x-anchor` keeps it pinned to the trigger
         (and repositions on scroll/resize), so it still points at the right spot. --}}
    <template x-teleport="body">
        <span
            x-show="show"
            x-cloak
            {{ $anchor }}="$refs.trigger"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            role="tooltip"
            class="pointer-events-none z-50 whitespace-nowrap rounded-md border border-secondary bg-bg px-2.5 py-1.5 text-xs font-medium text-text shadow-xl"
        >{{ $text }}</span>
    </template>
</span>
