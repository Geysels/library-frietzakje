@php
    $anchor = 'x-anchor.'.($align === 'left' ? 'bottom-start' : 'bottom-end').'.offset.6';
@endphp

<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    {{ $attributes->class('relative inline-block text-left') }}
>
    <div x-ref="trigger" @click="open = ! open">
        {{ $trigger }}
    </div>

    <template x-teleport="body">
        <div
            x-show="open"
            x-cloak
            {{ $anchor }}="$refs.trigger"
            @click.outside="open = false"
            @click="open = false"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="z-50 {{ $width }} rounded-lg border border-secondary bg-bg p-1 shadow-panel"
            role="menu"
        >
            {{ $slot }}
        </div>
    </template>
</div>
