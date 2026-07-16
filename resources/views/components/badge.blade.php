@props([
    'variant' => 'neutral',
    'size' => 'md',
])

@php
    $base = 'inline-flex items-center gap-1 rounded-md border';

    // The canonical variant set, shared by every colour-bearing component in the library:
    // neutral, primary, secondary, success, warning, danger, message, accent, accent-2.
    $variants = [
        'neutral' => 'border-secondary bg-secondary/40 text-text/80',
        'primary' => 'border-primary/40 bg-primary/15 text-primary',
        'secondary' => 'border-secondary bg-secondary text-text',
        'success' => 'border-success/40 bg-success/10 text-success',
        'warning' => 'border-warning/40 bg-warning/10 text-warning',
        'danger' => 'border-danger/40 bg-danger/10 text-danger',
        'message' => 'border-message/40 bg-message/10 text-message',
        'accent' => 'border-accent/40 bg-accent/15 text-accent-2',
        'accent-2' => 'border-accent-2/40 bg-accent-2/10 text-accent-2',

        // Kept as an alias: `info` predates `message` and is used by existing callers.
        'info' => 'border-message/40 bg-message/10 text-message',
    ];

    $sizes = [
        'sm' => 'px-1.5 py-0 text-xs',
        'md' => 'px-2 py-0.5 text-xs',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['neutral']).' '.($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->class($classes) }}>{{ $slot }}</span>
