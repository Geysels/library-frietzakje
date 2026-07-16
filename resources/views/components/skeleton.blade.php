@props([
    'variant' => 'text',
    'lines' => 3,
])

@php
    $shimmer = 'animate-pulse bg-secondary/60';
@endphp

@if ($variant === 'circle')
    <div {{ $attributes->class($shimmer.' size-10 rounded-full') }}></div>
@elseif ($variant === 'rect')
    <div {{ $attributes->class($shimmer.' h-24 w-full rounded-lg') }}></div>
@else
    <div {{ $attributes->class('space-y-2') }}>
        @for ($i = 0; $i < $lines; $i++)
            <div class="{{ $shimmer }} h-3 rounded {{ ($i === $lines - 1 && $lines > 1) ? 'w-2/3' : 'w-full' }}"></div>
        @endfor
    </div>
@endif
