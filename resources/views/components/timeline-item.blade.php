@php
    $variants = [
        'neutral' => 'border-secondary bg-secondary/40 text-text/70',
        'primary' => 'border-primary/40 bg-primary/15 text-primary',
        'secondary' => 'border-secondary bg-secondary text-text',
        'success' => 'border-success/40 bg-success/10 text-success',
        'warning' => 'border-warning/40 bg-warning/10 text-warning',
        'danger' => 'border-danger/40 bg-danger/10 text-danger',
        'message' => 'border-message/40 bg-message/10 text-message',
        'accent' => 'border-accent/40 bg-accent/15 text-accent-2',
        'accent-2' => 'border-accent-2/40 bg-accent-2/10 text-accent-2',
    ];

    $dotClasses = $variants[$variant] ?? $variants['neutral'];
@endphp

{{-- The connector is drawn on the item, not the list, so the last one can drop it
     without the parent having to know how many children it has. --}}
<li {{ $attributes->class('relative flex gap-4 pb-6 last:pb-0') }}>
    <div class="absolute bottom-0 left-[19px] top-10 w-px bg-secondary [li:last-child_&]:hidden"></div>

    <div class="relative z-10 grid size-10 flex-shrink-0 place-items-center rounded-full border {{ $dotClasses }}">
        <x-frietzakje-icon :name="$icon ?? 'radio_button_checked'" class="text-lg" />
    </div>

    <div class="min-w-0 flex-1 pt-1">
        <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1">
            @if ($title)
                <p class="font-display font-semibold">{{ $title }}</p>
            @endif

            @if ($time)
                <span class="text-xs text-text/50">{{ $time }}</span>
            @endif
        </div>

        @if ($slot->isNotEmpty())
            <div class="mt-1 text-sm text-text/70">{{ $slot }}</div>
        @endif
    </div>
</li>
