@php
    $sizes = [
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-12 h-12 text-base',
        'xl' => 'w-16 h-16 text-lg',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $initials = $fallback ?? strtoupper(substr($alt, 0, 2));
@endphp

<div {{ $attributes->class($sizeClass.' rounded-full overflow-hidden flex items-center justify-center bg-secondary text-text font-display font-semibold') }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="w-full h-full object-cover">
    @else
        <span>{{ $initials }}</span>
    @endif
</div>
