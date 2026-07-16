@php
    $percentage = min(100, max(0, ($value / max(1, $max)) * 100));

    $variants = [
        'neutral'   => 'bg-text/30',
        'primary'   => 'bg-primary',
        'secondary' => 'bg-secondary',
        'success'   => 'bg-success',
        'warning'   => 'bg-warning',
        'danger'    => 'bg-danger',
        'message'   => 'bg-message',
        'accent'    => 'bg-accent',
        'accent-2'  => 'bg-accent-2',
    ];
    $barClass = $variants[$variant] ?? $variants['primary'];

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

    $brightFill = ! in_array($variant, ['secondary', 'accent']);
    $twoTone = $labelColor === 'auto' && $brightFill;
    $labelTextClass = match ($labelColor) {
        'auto'  => 'text-white',
        'light' => 'text-white',
        'dark'  => 'text-bg',
        default => $labelColor,
    };
@endphp

<div {{ $attributes->merge(['style' => "--fz-progress: {$percentage}%"])->class('space-y-1') }}>
    @if ($showLabel && ! $inside)
        <div class="flex justify-between text-sm text-text/70">
            <span>{{ $slotText }}</span>
            <span>{{ $autoLabel }}</span>
        </div>
    @endif

    @if ($inside)
        <div class="relative h-5 w-full overflow-hidden rounded-full bg-secondary">
            <div
                class="{{ $barInner }}"
                role="progressbar"
                aria-valuenow="{{ $value }}"
                aria-valuemin="0"
                aria-valuemax="{{ $max }}"
            ></div>
            @if ($twoTone)
                <span class="pointer-events-none absolute inset-0 flex items-center justify-center text-xs font-semibold text-white">{{ $labelText }}</span>
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
