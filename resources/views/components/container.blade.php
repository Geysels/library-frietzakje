@php
    $sizeClasses = [
        'sm' => 'max-w-3xl',
        'default' => 'max-w-5xl',
        'lg' => 'max-w-7xl',
        'xl' => 'max-w-[90rem]',
        'full' => 'max-w-full',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['default'];
@endphp

<div {{ $attributes->class('mx-auto w-full px-4 ' . $sizeClass) }}>
    {{ $slot }}
</div>
