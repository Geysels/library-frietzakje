@php
    $colsClasses = [
        '1' => 'grid-cols-1',
        '2' => 'grid-cols-1 md:grid-cols-2',
        '3' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        '4' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
        '6' => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6',
        '12' => 'grid-cols-4 md:grid-cols-6 lg:grid-cols-12',
    ];

    $gapClasses = [
        '0' => 'gap-0',
        '1' => 'gap-1',
        '2' => 'gap-2',
        '3' => 'gap-3',
        '4' => 'gap-4',
        '6' => 'gap-6',
        '8' => 'gap-8',
    ];

    $colClass = $colsClasses[$cols] ?? $colsClasses['1'];
    $gapClass = $gapClasses[$gap] ?? $gapClasses['4'];
@endphp

<div {{ $attributes->class('grid ' . $colClass . ' ' . $gapClass) }}>
    {{ $slot }}
</div>
