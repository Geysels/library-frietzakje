@php
    $id = $attributes->get('id') ?? ($name ? 'toggle-'.$name : null);
@endphp

<div class="flex items-center gap-3" x-data="{ checked: {{ $attributes->get('checked') ? 'true' : 'false' }} }">
    <button
        type="button"
        @click="checked = !checked; $refs.input.checked = checked; $refs.input.dispatchEvent(new Event('change'))"
        :class="checked ? 'bg-primary' : 'bg-secondary'"
        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/40 focus:ring-offset-2 focus:ring-offset-bg"
        role="switch"
        :aria-checked="checked"
    >
        <span
            :class="checked ? 'translate-x-5' : 'translate-x-0'"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-bg shadow ring-0 transition duration-200 ease-in-out"
        ></span>
    </button>

    <input
        type="checkbox"
        x-ref="input"
        id="{{ $id }}"
        @if($name) name="{{ $name }}" @endif
        class="sr-only"
        {{ $attributes->except(['class', 'x-data']) }}
    >

    @if($label)
        <label for="{{ $id }}" class="text-sm cursor-pointer" @click="checked = !checked; $refs.input.checked = checked; $refs.input.dispatchEvent(new Event('change'))">{{ $label }}</label>
    @endif
</div>
