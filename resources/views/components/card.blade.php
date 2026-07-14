@php
    // Border colour is a prop, so highlighting a card (current plan, danger zone) doesn't
    // mean fighting the base class with an important override.
    $borders = [
        'default' => 'border-secondary',
        'neutral' => 'border-secondary',
        'primary' => 'border-primary',
        'secondary' => 'border-secondary',
        'success' => 'border-success',
        'warning' => 'border-warning',
        'danger' => 'border-danger',
        'message' => 'border-message',
        'accent' => 'border-accent',
        'accent-2' => 'border-accent-2',
    ];

    $classes = 'rounded-lg border bg-bg/40 backdrop-blur-sm '.($borders[$variant] ?? $borders['default']);

    if ($padded) { $classes .= ' p-5'; }
    if ($hoverable) { $classes .= ' transition-colors duration-150 hover:border-primary/60'; }
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
