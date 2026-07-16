@props([
    'variant'   => 'default',
    'border'    => 'default',
    'padding'   => null,
    'padded'    => false,
    'hoverable' => false,
])

@php
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

    $pad = $paddings[$padding] ?? ($padded ? $paddings['md'] : '');

    $classes = 'rounded-lg bg-bg/40 backdrop-blur-sm border-secondary '
        .($borderWidths[$border] ?? $borderWidths['default'])
        .($pad !== '' ? ' '.$pad : '');

    if ($hoverable) {
        $classes .= ' transition-[border-color,box-shadow] duration-300 ease-out hover:shadow-panel '
            .($hoverBorders[$variant] ?? $hoverBorders['default']);
    }
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
