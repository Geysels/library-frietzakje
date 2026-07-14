@php
    $positionClasses = [
        'top-right' => 'top-4 right-4',
        'top-left' => 'top-4 left-4',
        'top-center' => 'top-4 left-1/2 -translate-x-1/2',
        'bottom-right' => 'bottom-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'bottom-center' => 'bottom-4 left-1/2 -translate-x-1/2',
    ];

    $variantClasses = [
        'neutral' => 'bg-secondary text-text',
        'primary' => 'bg-primary text-bg',
        'secondary' => 'bg-secondary text-text',
        'success' => 'bg-success text-bg',
        'warning' => 'bg-warning text-bg',
        'danger' => 'bg-danger text-bg',
        'message' => 'bg-message text-bg',
        'accent' => 'bg-accent text-text',
        'accent-2' => 'bg-accent-2 text-text',
    ];

    $posClass = $positionClasses[$position] ?? $positionClasses['top-right'];
    $varClass = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

<div
    x-data="{
        show: false,
        message: '',
        timer: null,
        currentVariant: '{{ $variant }}',
        {{-- This map is what actually colours the toast at runtime: it is keyed by the variant
             carried on the dispatched event, so it has to stay in step with the PHP map above. --}}
        variantClasses: @js($variantClasses),
        fire(detail) {
            detail = typeof detail === 'string' ? { message: detail } : (detail || {});
            this.message = detail.message || 'Notification';
            this.currentVariant = detail.variant || '{{ $variant }}';
            this.show = true;

            // Restart the countdown on every toast. Without this, a toast fired while a
            // previous one is still up inherits the older timer and vanishes early.
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.show = false, detail.duration || 3000);
        }
    }"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @toast.window="fire($event.detail)"
    :class="variantClasses[currentVariant]"
    {{ $attributes->class('fixed z-[9999] flex items-center gap-3 rounded-lg px-4 py-3 shadow-lg ' . $posClass) }}
>
    <span x-text="message">{{ $slot }}</span>
    <button @click="show = false" class="ml-2 opacity-70 hover:opacity-100" aria-label="Close">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
