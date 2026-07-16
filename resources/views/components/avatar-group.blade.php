@php
    $ringSizes = [
        'sm' => 'size-8 text-xs',
        'md' => 'size-10 text-sm',
        'lg' => 'size-12 text-base',
    ];

    $sizeClass = $ringSizes[$size] ?? $ringSizes['sm'];
@endphp

<div {{ $attributes->class('flex -space-x-2') }}>
    @foreach ($visible() as $user)
        <div
            class="{{ $sizeClass }} grid place-items-center overflow-hidden rounded-full bg-secondary font-display font-semibold text-text ring-2 ring-bg"
            title="{{ $user['name'] }}"
        >
            @if (! empty($user['src']))
                <img src="{{ $user['src'] }}" alt="{{ $user['name'] }}" class="size-full object-cover">
            @else
                <span>{{ strtoupper(mb_substr($user['name'], 0, 2)) }}</span>
            @endif
        </div>
    @endforeach

    @if ($overflow() > 0)
        <div class="{{ $sizeClass }} grid place-items-center rounded-full bg-secondary/60 font-display font-semibold text-text/70 ring-2 ring-bg">
            +{{ $overflow() }}
        </div>
    @endif
</div>
