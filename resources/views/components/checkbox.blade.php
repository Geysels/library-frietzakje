@php
    $id = $attributes->get('id') ?? ($name ? 'checkbox-'.$name : null);
@endphp

{{-- A themed checkbox. The native box can't be styled on a dark theme, so `appearance-none`
     strips it and we draw our own: a rounded square that fills with the primary colour and shows
     a checkmark when ticked. The checkmark is a sibling of the input so `peer-checked` can reveal
     it. Any attribute (checked, value, x-model, wire:model, disabled) passes straight through. --}}
<div class="flex items-start gap-2.5">
    <span class="relative mt-0.5 inline-flex shrink-0">
        <input
            type="checkbox"
            id="{{ $id }}"
            @if($name) name="{{ $name }}" @endif
            {{ $attributes->class('peer size-5 shrink-0 cursor-pointer appearance-none rounded border-2 border-secondary bg-bg transition-colors checked:border-primary checked:bg-primary hover:border-text/40 checked:hover:border-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2 focus-visible:ring-offset-bg disabled:cursor-not-allowed disabled:opacity-50') }}
        >
        <svg
            class="pointer-events-none absolute inset-0 m-auto size-3.5 text-bg opacity-0 transition-opacity peer-checked:opacity-100"
            viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
        >
            <path d="M4.5 10.5l3.5 3.5L15.5 6" />
        </svg>
    </span>

    @if($label || $help)
        <div class="grid gap-1">
            @if($label)
                <label for="{{ $id }}" class="cursor-pointer text-sm">{{ $label }}</label>
            @endif
            @if($help)
                <small class="text-text/60">{{ $help }}</small>
            @endif
        </div>
    @endif
</div>
