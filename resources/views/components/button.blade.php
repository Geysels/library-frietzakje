@php
    // `fz-ripple` marks the button for the click-ripple in app.js (it also sets
    // position/overflow so the ink is clipped to the rounded shape).
    $base = 'fz-ripple inline-flex items-center justify-center gap-2 rounded-md font-display tracking-tight'
        .' transition-[filter,color,background-color,border-color] duration-150'
        .' focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-bg'
        .' disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:filter-none';

    // Solid darkens on hover (brightness-90); outline does the opposite — its
    // tint fills in and grows more visible.
    $variants = [
        // Solid variants
        'primary' => 'bg-primary text-bg font-bold hover:brightness-90 focus-visible:ring-primary',
        'success' => 'bg-success text-bg font-bold hover:brightness-90 focus-visible:ring-success',
        'danger' => 'bg-danger text-bg font-bold hover:brightness-90 focus-visible:ring-danger',
        'message' => 'bg-message text-bg font-bold hover:brightness-90 focus-visible:ring-message',
        'warning' => 'bg-warning text-bg font-bold hover:brightness-90 focus-visible:ring-warning',
        'secondary' => 'bg-secondary text-text font-bold hover:brightness-90 focus-visible:ring-secondary',
        'neutral' => 'bg-secondary text-text font-bold hover:brightness-90 focus-visible:ring-secondary',
        'accent' => 'bg-accent text-text font-bold hover:brightness-90 focus-visible:ring-accent',
        'accent-2' => 'bg-accent-2 text-text font-bold hover:brightness-90 focus-visible:ring-accent-2',

        // Outline variants
        'primary-outline' => 'border-2 border-primary text-primary hover:bg-primary/20 focus-visible:ring-primary',
        'success-outline' => 'border-2 border-success text-success hover:bg-success/20 focus-visible:ring-success',
        'danger-outline' => 'border-2 border-danger text-danger hover:bg-danger/20 focus-visible:ring-danger',
        'warning-outline' => 'border-2 border-warning text-warning hover:bg-warning/20 focus-visible:ring-warning',
        'message-outline' => 'border-2 border-message text-message hover:bg-message/20 focus-visible:ring-message',
        'secondary-outline' => 'border-2 border-secondary text-text hover:bg-secondary/60 focus-visible:ring-secondary',
        // Accent is a dark blue — its own colour is unreadable as text on the dark
        // surface, so (like secondary) the label stays white and the tint fills on hover.
        'accent-outline' => 'border-2 border-accent text-text hover:bg-accent/40 focus-visible:ring-accent',
        'accent-2-outline' => 'border-2 border-accent-2 text-accent-2 hover:bg-accent-2/20 focus-visible:ring-accent-2',

        // Ghost variant (no background or border)
        'ghost' => 'hover:bg-secondary/40 focus-visible:ring-primary',
    ];

    $sizes = [
        'sm' => 'px-2.5 py-1 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-5 py-2.5 text-base',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>
        @if ($attributes->whereStartsWith('wire:click')->isNotEmpty() || $attributes->whereStartsWith('wire:submit')->isNotEmpty())
            {{-- Spinner during the matching wire action. --}}
            @php $action = $attributes->whereStartsWith('wire:click')->first() ?? $attributes->whereStartsWith('wire:submit')->first(); @endphp
        @endif
        {{ $slot }}
    </button>
@endif
