@php
    $id = $attributes->get('id') ?? ($name ? 'checkbox-'.$name : null);
@endphp

<div class="flex items-start gap-2">
    <input
        type="checkbox"
        id="{{ $id }}"
        @if($name) name="{{ $name }}" @endif
        {{ $attributes->class('w-4 h-4 mt-0.5 rounded border-secondary bg-bg text-primary focus:ring-2 focus:ring-primary/40 focus:ring-offset-0 transition-colors') }}
    >

    @if($label || $help)
        <div class="grid gap-1">
            @if($label)
                <label for="{{ $id }}" class="text-sm cursor-pointer">{{ $label }}</label>
            @endif
            @if($help)
                <small class="text-text/60">{{ $help }}</small>
            @endif
        </div>
    @endif
</div>
