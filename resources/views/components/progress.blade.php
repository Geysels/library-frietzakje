@php
    $percentage = min(100, max(0, ($value / $max) * 100));

    $variants = [
        'primary' => 'bg-primary',
        'success' => 'bg-success',
        'danger' => 'bg-danger',
        'message' => 'bg-message',
    ];

    $barClass = $variants[$variant] ?? $variants['primary'];
@endphp

<div {{ $attributes->class('space-y-1') }}>
    @if($showLabel)
        <div class="flex justify-between text-sm text-text/70">
            <span>{{ $slot }}</span>
            <span>{{ number_format($percentage, 0) }}%</span>
        </div>
    @endif

    <div class="w-full h-2 bg-secondary rounded-full overflow-hidden">
        <div class="{{ $barClass }} h-full rounded-full transition-all duration-300 ease-out" style="width: {{ $percentage }}%"></div>
    </div>
</div>
