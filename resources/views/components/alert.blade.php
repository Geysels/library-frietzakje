@php
    $base = 'rounded-lg border p-4';

    $variants = [
        'info' => 'border-message/40 bg-message/10 text-message',
        'success' => 'border-success/40 bg-success/10 text-success',
        'warning' => 'border-accent-2/40 bg-accent-2/10 text-accent-2',
        'danger' => 'border-danger/40 bg-danger/10 text-danger',
    ];

    $icons = [
        'info' => 'info',
        'success' => 'check_circle',
        'warning' => 'warning',
        'danger' => 'error',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['info']);
@endphp

<div {{ $attributes->class($classes) }} @if($dismissible) x-data="{ show: true }" x-show="show" @endif>
    <div class="flex items-start gap-3">
        <x-frietzakje-icon :name="$icons[$variant] ?? 'info'" class="text-xl shrink-0" />

        <div class="flex-1 space-y-1">
            @if($title)
                <h4 class="font-display font-semibold">{{ $title }}</h4>
            @endif
            <div class="text-sm">{{ $slot }}</div>
        </div>

        @if($dismissible)
            <button @click="show = false" class="shrink-0 opacity-70 hover:opacity-100 transition-opacity">
                <x-frietzakje-icon name="close" class="text-lg" />
            </button>
        @endif
    </div>
</div>
