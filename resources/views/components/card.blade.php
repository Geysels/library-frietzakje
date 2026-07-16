@props([
    'variant' => 'default',   // hover-border accent colour (a hoverable card lifts to this)
    'border' => 'default',    // thickness: thin | default | medium | thick
    'padding' => null,        // amount: none | sm | md | lg  (falls back to the legacy `padded`)
    'padded' => false,        // legacy boolean — true == padding="md"
    'hoverable' => false,
])

@php
    // On hover, a hoverable card raises its border to this theme colour.
    $hoverBorders = [
        'default'   => 'hover:border-primary/60',
        'primary'   => 'hover:border-primary',
        'success'   => 'hover:border-success',
        'danger'    => 'hover:border-danger',
        'warning'   => 'hover:border-warning',
        'message'   => 'hover:border-message',
        'secondary' => 'hover:border-text/40',
        'accent'    => 'hover:border-accent',
        'accent-2'  => 'hover:border-accent-2',
    ];

    $borderWidths = [
        'thin'    => 'border',
        'default' => 'border',
        'medium'  => 'border-2',
        'thick'   => 'border-4',
    ];

    $paddings = [
        'none' => '',
        'sm'   => 'p-3',
        'md'   => 'p-5',
        'lg'   => 'p-8',
    ];

    // Explicit `padding` wins; otherwise the legacy boolean maps to md.
    $pad = $paddings[$padding] ?? ($padded ? $paddings['md'] : '');

    $classes = 'rounded-lg bg-bg/40 backdrop-blur-sm border-secondary '
        .($borderWidths[$border] ?? $borderWidths['default'])
        .($pad !== '' ? ' '.$pad : '');

    if ($hoverable) {
        // Smooth, not a flicker: a longer, eased transition on the border, plus a soft shadow.
        $classes .= ' transition-[border-color,box-shadow] duration-300 ease-out hover:shadow-panel '
            .($hoverBorders[$variant] ?? $hoverBorders['default']);
    }
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
