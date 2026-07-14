@php
    $sizes = [
        'sm' => 'w-4 h-4',
        'md' => 'w-6 h-6',
        'lg' => 'w-8 h-8',
        'xl' => 'w-12 h-12',
    ];

    // `current` inherits the surrounding text colour, which is what you want inside a button.
    // The named variants are for a spinner standing on its own.
    $variants = [
        'current' => 'text-current',
        'neutral' => 'text-text/60',
        'primary' => 'text-primary',
        'secondary' => 'text-text/80',
        'success' => 'text-success',
        'warning' => 'text-warning',
        'danger' => 'text-danger',
        'message' => 'text-message',
        'accent' => 'text-accent-2',
        'accent-2' => 'text-accent-2',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClass = $variants[$variant] ?? $variants['current'];
@endphp

<svg {{ $attributes->class($sizeClass.' '.$variantClass.' animate-spin') }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" role="status" aria-label="Loading">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
