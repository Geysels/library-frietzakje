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

    // The auto label is a percentage by default, or an X/Y fraction with format="fraction".
    // A non-empty slot overrides it with whatever the caller wrote ("77/150 taken klaar").
    $autoLabel = $format === 'fraction' ? $value.'/'.$max : number_format($percentage, 0).'%';
    $labelText = $slot->isNotEmpty() ? $slot : $autoLabel;

    $barInner = 'fz-progress-bar '.$barClass.' h-full rounded-full transition-all duration-300 ease-out'
        .($animated ? ' fz-progress-animated' : '');
@endphp

{{-- The width rides on a CSS custom property rather than an inline `width:`, so a caller can
     drive it from Alpine — x-bind:style="{'--fz-progress': pct + '%'}" — instead of having to
     hand-roll a bar whenever the value is client-side state.

     The property is declared on the ROOT and inherited by the bar, not declared on the bar
     itself: a declaration on the bar would be a value on that element and would win over
     anything a caller could reach, which made the binding above silently do nothing. --}}
<div {{ $attributes->merge(['style' => "--fz-progress: {$percentage}%"])->class('space-y-1') }}>
    @if ($showLabel && ! $inside)
        <div class="flex justify-between text-sm text-text/70">
            <span>{{ $slot }}</span>
            <span>{{ $autoLabel }}</span>
        </div>
    @endif

    @if ($inside)
        {{-- A taller track so the label reads inside it. The label is centred over the whole bar
             (not tucked in the fill), so it stays legible at any percentage and fits longer
             custom text like "77/150 taken klaar". --}}
        <div class="relative h-5 w-full overflow-hidden rounded-full bg-secondary">
            <div
                class="{{ $barInner }}"
                role="progressbar"
                aria-valuenow="{{ $value }}"
                aria-valuemin="0"
                aria-valuemax="{{ $max }}"
            ></div>
            <span class="pointer-events-none absolute inset-0 flex items-center justify-center text-xs font-semibold text-text">{{ $labelText }}</span>
        </div>
    @else
        <div class="h-2 w-full overflow-hidden rounded-full bg-secondary">
            <div
                class="{{ $barInner }}"
                role="progressbar"
                aria-valuenow="{{ $value }}"
                aria-valuemin="0"
                aria-valuemax="{{ $max }}"
            ></div>
        </div>
    @endif
</div>
