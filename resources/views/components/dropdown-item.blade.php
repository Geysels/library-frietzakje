@php
    $variants = [
        'default'   => 'text-text/85 hover:bg-secondary/50 hover:text-text',
        'neutral'   => 'text-text/85 hover:bg-secondary/50 hover:text-text',
        'primary'   => 'text-primary hover:bg-primary/10',
        'secondary' => 'text-text hover:bg-secondary',
        'success'   => 'text-success hover:bg-success/10',
        'warning'   => 'text-warning hover:bg-warning/10',
        'danger'    => 'text-danger hover:bg-danger/10',
        'message'   => 'text-message hover:bg-message/10',
        'accent'    => 'text-accent-2 hover:bg-accent/15',
        'accent-2'  => 'text-accent-2 hover:bg-accent-2/10',
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
