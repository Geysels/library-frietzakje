@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-md font-display tracking-tight'
        .' transition-colors duration-150'
        .' focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-bg'
        .' disabled:cursor-not-allowed disabled:opacity-50';

    $variants = [
        'primary' => 'bg-primary text-bg font-bold hover:brightness-95 focus-visible:ring-primary',
        'secondary' => 'border border-secondary bg-bg hover:border-primary hover:text-primary focus-visible:ring-primary',
        'ghost' => 'hover:bg-secondary/40 focus-visible:ring-primary',
        'success' => 'bg-success text-bg font-bold hover:brightness-95 focus-visible:ring-success',
        'danger' => 'border border-danger text-danger hover:bg-danger/10 focus-visible:ring-danger',
        'danger-solid' => 'bg-danger text-bg font-bold hover:brightness-95 focus-visible:ring-danger',
    ];

    $sizes = [
        'sm' => 'px-2.5 py-1 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-5 py-2.5 text-base',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>
        @if ($attributes->whereStartsWith('wire:click')->isNotEmpty() || $attributes->whereStartsWith('wire:submit')->isNotEmpty())
            {{-- Spinner during the matching wire action. --}}
            @php $action = $attributes->whereStartsWith('wire:click')->first() ?? $attributes->whereStartsWith('wire:submit')->first(); @endphp
        @endif
        {{ $slot }}
    </button>
@endif
