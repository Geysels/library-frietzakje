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
            {{-- Last line runs short, the way a real paragraph does. --}}
            <div class="{{ $shimmer }} h-3 rounded {{ $loop->last && $lines > 1 ? 'w-2/3' : 'w-full' }}"></div>
        @endfor
    </div>
@endif
