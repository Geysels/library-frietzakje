@php
    // `fz-ripple` marks the button for the click-ripple in app.js (it also sets
    // position/overflow so the ink is clipped to the rounded shape).
    $base = 'fz-ripple inline-flex items-center justify-center gap-2 rounded-md font-display font-bold tracking-tight'
        .' transition-[filter,color,background-color,border-color] duration-150'
        .' focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-bg'
        .' disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:filter-none';

    // Two rules keep this legible and consistent:
    //  • Solid — background is the colour; the label takes whichever foreground has the
    //    most contrast on it. Our bright colours (primary/success/danger/warning/message/
    //    accent-2) read best with the dark surface colour (text-bg); the two genuinely dark
    //    colours (secondary/neutral, accent) need white (text-text). Hover darkens.
    //  • Outline — border + label in the matching colour, a subtle tint filling on hover.
    //    This is the "for a light surface" set; on the dark app background the dark colours
    //    (accent, secondary) are faint by design — use solid there instead.
    $variants = [
        // Solid variants — foreground chosen for contrast, not uniformity.
        'primary' => 'bg-primary text-bg hover:brightness-90 focus-visible:ring-primary',
        'success' => 'bg-success text-bg hover:brightness-90 focus-visible:ring-success',
        'danger' => 'bg-danger text-bg hover:brightness-90 focus-visible:ring-danger',
        'message' => 'bg-message text-bg hover:brightness-90 focus-visible:ring-message',
        'warning' => 'bg-warning text-bg hover:brightness-90 focus-visible:ring-warning',
        'accent-2' => 'bg-accent-2 text-bg hover:brightness-90 focus-visible:ring-accent-2',
        'secondary' => 'bg-secondary text-text hover:brightness-90 focus-visible:ring-secondary',
        'neutral' => 'bg-secondary text-text hover:brightness-90 focus-visible:ring-secondary',
        'accent' => 'bg-accent text-text hover:brightness-90 focus-visible:ring-accent',

        // Outline variants — matching colour throughout, uniform hover fill.
        'primary-outline' => 'border-2 border-primary text-primary hover:bg-primary/15 focus-visible:ring-primary',
        'success-outline' => 'border-2 border-success text-success hover:bg-success/15 focus-visible:ring-success',
        'danger-outline' => 'border-2 border-danger text-danger hover:bg-danger/15 focus-visible:ring-danger',
        'warning-outline' => 'border-2 border-warning text-warning hover:bg-warning/15 focus-visible:ring-warning',
        'message-outline' => 'border-2 border-message text-message hover:bg-message/15 focus-visible:ring-message',
        'secondary-outline' => 'border-2 border-secondary text-secondary hover:bg-secondary/15 focus-visible:ring-secondary',
        'accent-outline' => 'border-2 border-accent text-accent hover:bg-accent/15 focus-visible:ring-accent',
        'accent-2-outline' => 'border-2 border-accent-2 text-accent-2 hover:bg-accent-2/15 focus-visible:ring-accent-2',

        // Ghost variant (no background or border)
        'ghost' => 'hover:bg-secondary/40 focus-visible:ring-primary',
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
