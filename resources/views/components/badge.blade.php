@php
    $base = 'inline-flex items-center gap-1 rounded-md border';

    $variants = [
        'neutral' => 'border-secondary bg-secondary/40 text-text/80',
        'primary' => 'border-primary/40 bg-primary/15 text-primary',
        'success' => 'border-success/40 bg-success/10 text-success',
        // `warning` exists on alert, so it has to exist here too — without it anything merely
        // expiring has to be badged as if it had already failed.
        'warning' => 'border-accent-2/40 bg-accent-2/10 text-accent-2',
        'danger' => 'border-danger/40 bg-danger/10 text-danger',
        'info' => 'border-message/40 bg-message/10 text-message',
    ];

    $sizes = [
        'sm' => 'px-1.5 py-0 text-xs',
        'md' => 'px-2 py-0.5 text-xs',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['neutral']).' '.($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->class($classes) }}>{{ $slot }}</span>
