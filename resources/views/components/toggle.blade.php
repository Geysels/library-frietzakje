@php
    $id = $attributes->get('id') ?? ($name ? 'toggle-'.$name : null);
    $initial = $attributes->get('checked') ? 'true' : 'false';
@endphp

<div
    {{ $attributes->only('class')->class('flex items-start gap-3') }}
    x-data="{
        checked: {{ $initial }},
        toggle() {
            this.checked = ! this.checked;
            this.$refs.input.checked = this.checked;

            // `bubbles: true` matters: without it the event dies on the hidden input and a
            // form-level @change listener — the usual way to track a dirty form — never sees
            // the toggle flip.
            this.$refs.input.dispatchEvent(new Event('change', { bubbles: true }));
        },
    }"
    x-init="
        // A native form.reset() rewinds the hidden input but knows nothing about the knob,
        // so re-read the input afterwards or the two drift apart.
        $el.closest('form')?.addEventListener('reset', () => queueMicrotask(() => checked = $refs.input.checked));
    "
>
    <button
        type="button"
        @click="toggle()"
        :class="checked ? 'bg-primary' : 'bg-secondary'"
        class="relative mt-0.5 inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/40 focus:ring-offset-2 focus:ring-offset-bg"
        role="switch"
        :aria-checked="checked"
        @if ($id) aria-labelledby="{{ $id }}-label" @endif
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
        @if ($name) name="{{ $name }}" @endif
        class="sr-only"
        {{ $attributes->except(['class', 'x-data']) }}
    >

    @if ($label || $help)
        <div class="min-w-0 flex-1">
            @if ($label)
                <label
                    id="{{ $id }}-label"
                    for="{{ $id }}"
                    class="block cursor-pointer text-sm"
                    @click.prevent="toggle()"
                >{{ $label }}</label>
            @endif

            @if ($help)
                <small class="text-text/60">{{ $help }}</small>
            @endif
        </div>
    @endif
</div>
