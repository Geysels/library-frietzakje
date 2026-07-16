@php
    $variants = [
        'default' => 'text-primary hover:underline',
        'muted'   => 'text-text/60 hover:text-text',
        'button'  => 'inline-flex items-center gap-2 rounded-md px-4 py-2 bg-primary text-bg font-display font-bold hover:brightness-95 transition-all',
    ];

    $classes = $variants[$variant] ?? $variants['default'];
@endphp

<a href="{{ $href }}" {{ $attributes->class($classes.' transition-colors') }}>
    {{ $slot }}
</a>
