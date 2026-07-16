@props(['href', 'icon' => null, 'active' => false, 'badge' => null])

@php
    $classes = $active
        ? 'bg-primary/15 text-primary'
        : 'text-text/85 hover:bg-secondary/40';
@endphp

<li>
    <a href="{{ $href }}"
       @if (function_exists('wire')) wire:navigate @endif
       @click="sidebarOpen = false"
       {{ $attributes->class([
           'flex items-center gap-3 rounded-lg px-3 py-2 transition-colors duration-150',
           $classes,
       ]) }}
       aria-current="{{ $active ? 'page' : 'false' }}">
        @if ($icon)
            <x-frietzakje-icon :name="$icon" class="text-xl" />
        @endif
        <span class="text-sm font-medium flex-1">{{ $slot }}</span>
        @if ($badge)
            <x-frietzakje-badge variant="neutral" class="ml-auto">{{ $badge }}</x-frietzakje-badge>
        @endif
    </a>
</li>
