@php
    $id = $attributes->get('id') ?? 'accordion-'.uniqid();
@endphp

<div {{ $attributes->class('border border-secondary rounded-lg overflow-hidden') }} x-data="{ open: {{ $open ? 'true' : 'false' }} }">
    <button
        type="button"
        @click="open = !open"
        class="w-full flex items-center justify-between p-4 text-left hover:bg-secondary/40 transition-colors"
        :aria-expanded="open"
    >
        <span class="font-display font-semibold">{{ $title }}</span>
        <x-frietzakje-icon name="expand_more" class="text-xl transition-transform duration-200" :class="open && 'rotate-180'" x-bind:class="open ? 'rotate-180' : ''" />
    </button>

    <div x-show="open" x-collapse>
        <div class="p-4 border-t border-secondary">
            {{ $slot }}
        </div>
    </div>
</div>
