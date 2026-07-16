@php
    $sizes = [
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-12 h-12 text-base',
        'xl' => 'w-16 h-16 text-lg',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];

    $fb = $fallback ?? null;
    if ($fb !== null && $fb !== '') {
        $initials = $fb;
    } else {
        $parts = preg_split('/\s+/', trim((string) ($alt ?? '')), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $initials = match (true) {
            count($parts) >= 2 => mb_substr($parts[0], 0, 1).mb_substr(end($parts), 0, 1),
            count($parts) === 1 => mb_substr($parts[0], 0, 2),
            default => '',
        };
        $initials = mb_strtoupper($initials);
    }
@endphp

<div {{ $attributes->class($sizeClass.' shrink-0 rounded-full overflow-hidden flex items-center justify-center bg-secondary text-text font-display font-semibold') }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="w-full h-full object-cover">
    @else
        <span>{{ $initials }}</span>
    @endif
</div>
