@php
    // Border colour is a prop, so highlighting a card (current plan, danger zone) doesn't
    // mean fighting the base class with an important override.
    $borders = [
        'default' => 'border-secondary',
        'primary' => 'border-primary',
        'success' => 'border-success',
        'danger' => 'border-danger',
        'message' => 'border-message',
    ];

    $classes = 'rounded-lg border bg-bg/40 backdrop-blur-sm '.($borders[$variant] ?? $borders['default']);

    if ($padded) { $classes .= ' p-5'; }
    if ($hoverable) { $classes .= ' transition-colors duration-150 hover:border-primary/60'; }
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
