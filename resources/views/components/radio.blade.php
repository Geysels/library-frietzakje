@php
    $id = $attributes->get('id') ?? ($name && $value ? 'radio-'.$name.'-'.$value : null);
@endphp

<div class="flex items-center gap-2">
    <input
        type="radio"
        id="{{ $id }}"
        @if($name) name="{{ $name }}" @endif
        @if($value) value="{{ $value }}" @endif
        {{ $attributes->class('w-4 h-4 border-secondary bg-bg text-primary focus:ring-2 focus:ring-primary/40 focus:ring-offset-0 transition-colors') }}
    >

    @if($label)
        <label for="{{ $id }}" class="text-sm cursor-pointer">{{ $label }}</label>
    @endif
</div>
