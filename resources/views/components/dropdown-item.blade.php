@php
    $variants = [
        'default' => 'text-text/85 hover:bg-secondary/50 hover:text-text',
        'danger' => 'text-danger hover:bg-danger/10',
        'primary' => 'text-primary hover:bg-primary/10',
    ];

    $classes = 'flex w-full items-center gap-3 rounded-md px-3 py-2 text-left text-sm transition-colors duration-150 '
        .($variants[$variant] ?? $variants['default']);
@endphp

@if ($href)
    <a href="{{ $href }}" role="menuitem" {{ $attributes->class($classes) }}>
        @if ($icon)
            <x-frietzakje-icon :name="$icon" class="text-lg" />
        @endif
        {{ $slot }}
    </a>
@else
    <button type="button" role="menuitem" {{ $attributes->class($classes) }}>
        @if ($icon)
            <x-frietzakje-icon :name="$icon" class="text-lg" />
        @endif
        {{ $slot }}
    </button>
@endif
