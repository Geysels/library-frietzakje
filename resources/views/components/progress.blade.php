@php
    $percentage = min(100, max(0, ($value / max(1, $max)) * 100));

    $variants = [
        // Neutral first, and it is the sane default for a bar that is merely reporting a
        // number. Reach for a colour only when the value itself means something is wrong.
        'neutral' => 'bg-text/30',
        'primary' => 'bg-primary',
        'secondary' => 'bg-secondary',
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'danger' => 'bg-danger',
        'message' => 'bg-message',
        'accent' => 'bg-accent',
        'accent-2' => 'bg-accent-2',
    ];

    $barClass = $variants[$variant] ?? $variants['primary'];
@endphp

{{-- The width rides on a CSS custom property rather than an inline `width:`, so a caller can
     drive it from Alpine — :style="`--fz-progress: ${pct}%`" — instead of having to hand-roll
     a bar whenever the value is client-side state. --}}
<div {{ $attributes->class('space-y-1') }}>
    @if ($showLabel)
        <div class="flex justify-between text-sm text-text/70">
            <span>{{ $slot }}</span>
            <span>{{ number_format($percentage, 0) }}%</span>
        </div>
    @endif

    <div class="h-2 w-full overflow-hidden rounded-full bg-secondary">
        <div
            class="fz-progress-bar {{ $barClass }} h-full rounded-full transition-all duration-300 ease-out"
            style="--fz-progress: {{ $percentage }}%"
            role="progressbar"
            aria-valuenow="{{ $value }}"
            aria-valuemin="0"
            aria-valuemax="{{ $max }}"
        ></div>
    </div>
</div>
