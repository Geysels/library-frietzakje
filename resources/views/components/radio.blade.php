@php
    $id = $attributes->get('id') ?? ($name && $value ? 'radio-'.$name.'-'.$value : null);
@endphp

{{-- A themed radio, same approach as the checkbox: `appearance-none` strips the un-stylable
     native control and we draw a ring that turns primary with a filled dot when selected. The dot
     is a sibling of the input so `peer-checked` can reveal it. --}}
<div class="flex items-center gap-2.5">
    <span class="relative inline-flex shrink-0">
        <input
            type="radio"
            id="{{ $id }}"
            @if($name) name="{{ $name }}" @endif
            @if($value) value="{{ $value }}" @endif
            {{ $attributes->class('peer size-5 shrink-0 cursor-pointer appearance-none rounded-full border-2 border-secondary bg-bg transition-colors checked:border-primary hover:border-text/40 checked:hover:border-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2 focus-visible:ring-offset-bg disabled:cursor-not-allowed disabled:opacity-50') }}
        >
        <span class="pointer-events-none absolute inset-0 m-auto size-2.5 scale-0 rounded-full bg-primary transition-transform peer-checked:scale-100" aria-hidden="true"></span>
    </span>

    @if($label)
        <label for="{{ $id }}" class="cursor-pointer text-sm">{{ $label }}</label>
    @endif
</div>
