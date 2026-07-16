@php
    $last = $lastPage();
    $linkBase = 'grid size-9 place-items-center rounded-md text-sm transition-colors duration-150';
@endphp

<nav {{ $attributes->class('flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between') }} aria-label="Pagination">
    <p class="text-sm text-text/60">
        Showing <span class="font-semibold text-text">{{ $from() }}</span>–<span class="font-semibold text-text">{{ $to() }}</span>
        of <span class="font-semibold text-text">{{ number_format($total, 0, ',', '.') }}</span> {{ $label }}
    </p>

    <div class="flex items-center gap-1">
        @if ($page > 1)
            <a href="{{ $urlFor($page - 1) }}" rel="prev" aria-label="Previous page"
               class="{{ $linkBase }} text-text/70 hover:bg-secondary/50 hover:text-text">
                <x-frietzakje-icon name="chevron_left" class="text-lg" />
            </a>
        @else
            <span aria-disabled="true" class="{{ $linkBase }} cursor-not-allowed text-text/25">
                <x-frietzakje-icon name="chevron_left" class="text-lg" />
            </span>
        @endif

        @foreach ($pages() as $p)
            @if ($p === null)
                <span class="{{ $linkBase }} text-text/40">…</span>
            @elseif ($p === $page)
                <span aria-current="page" class="{{ $linkBase }} bg-primary font-bold text-bg">{{ $p }}</span>
            @else
                <a href="{{ $urlFor($p) }}" class="{{ $linkBase }} text-text/70 hover:bg-secondary/50 hover:text-text">{{ $p }}</a>
            @endif
        @endforeach

        @if ($page < $last)
            <a href="{{ $urlFor($page + 1) }}" rel="next" aria-label="Next page"
               class="{{ $linkBase }} text-text/70 hover:bg-secondary/50 hover:text-text">
                <x-frietzakje-icon name="chevron_right" class="text-lg" />
            </a>
        @else
            <span aria-disabled="true" class="{{ $linkBase }} cursor-not-allowed text-text/25">
                <x-frietzakje-icon name="chevron_right" class="text-lg" />
            </span>
        @endif
    </div>
</nav>
