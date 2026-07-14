@php
    $positions = [
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
    ];

    $posClass = $positions[$position] ?? $positions['top'];
@endphp

<span
    x-data="{ show: false }"
    @mouseenter="show = true"
    @mouseleave="show = false"
    @focusin="show = true"
    @focusout="show = false"
    {{ $attributes->class('relative inline-flex') }}
>
    {{ $slot }}

    <span
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        role="tooltip"
        class="pointer-events-none absolute z-50 {{ $posClass }} whitespace-nowrap rounded-md border border-secondary bg-bg px-2.5 py-1.5 text-xs font-medium text-text shadow-xl"
    >{{ $text }}</span>
</span>
