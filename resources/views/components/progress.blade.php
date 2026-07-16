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
    // A non-empty slot overrides it: the caller writes a template and we fill in the live numbers,
    // so "{value}/{max} taken klaar" becomes "77/150 taken klaar" and "{percent}% klaar" → "51%
    // klaar". Plain text with no placeholders is left untouched.
    $autoLabel = $format === 'fraction' ? $value.'/'.$max : number_format($percentage, 0).'%';
    $slotText = $slot->isNotEmpty()
        ? strtr(trim($slot->toHtml()), [
            '{value}'   => $value,
            '{max}'     => $max,
            '{percent}' => number_format($percentage, 0),
        ])
        : '';
    $labelText = $slotText !== '' ? $slotText : $autoLabel;

    $barInner = 'fz-progress-bar '.$barClass.' h-full rounded-full transition-all duration-300 ease-out'
        .($animated ? ' fz-progress-animated' : '');

    // The inside label spans two backgrounds at once: the dark unfilled track and the coloured
    // fill. A single colour can't read on both. So by default (labelColor="auto") over a BRIGHT
    // fill we draw the label twice — a light copy for the track and a dark copy clipped to exactly
    // the filled width — and let the colour split ride the fill edge per character. Dark-fill
    // variants (secondary/accent) are dark on both sides, so there we just use light text.
    // labelColor="light"|"dark" forces a single colour, or pass any text-* class straight through.
    $brightFill = ! in_array($variant, ['secondary', 'accent']);
    $twoTone = $labelColor === 'auto' && $brightFill;
    $labelTextClass = match ($labelColor) {
        'auto'  => 'text-white',
        'light' => 'text-white',
        'dark'  => 'text-bg',
        default => $labelColor,
    };
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
            <span>{{ $slotText }}</span>
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
            @if ($twoTone)
                {{-- Light copy for the dark track underneath… --}}
                <span class="pointer-events-none absolute inset-0 flex items-center justify-center text-xs font-semibold text-white">{{ $labelText }}</span>
                {{-- …and a dark copy clipped to exactly the filled width, so the colour split rides
                     the fill edge. The clip reads --fz-progress, so it tracks live/animated fills too. --}}
                <span class="pointer-events-none absolute inset-0 flex items-center justify-center text-xs font-semibold text-bg" style="clip-path: inset(0 calc(100% - var(--fz-progress)) 0 0)">{{ $labelText }}</span>
            @else
                <span class="pointer-events-none absolute inset-0 flex items-center justify-center text-xs font-semibold {{ $labelTextClass }}">{{ $labelText }}</span>
            @endif
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
