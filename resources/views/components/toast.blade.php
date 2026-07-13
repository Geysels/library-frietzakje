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
        'primary' => 'bg-primary text-bg',
        'success' => 'bg-success text-bg',
        'danger' => 'bg-danger text-bg',
        'message' => 'bg-message text-bg',
        'neutral' => 'bg-secondary text-text',
    ];

    $posClass = $positionClasses[$position] ?? $positionClasses['top-right'];
    $varClass = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

<div
    x-data="{
        show: false,
        message: '',
        currentVariant: '{{ $variant }}',
        variantClasses: {
            'primary': 'bg-primary text-bg',
            'success': 'bg-success text-bg',
            'danger': 'bg-danger text-bg',
            'message': 'bg-message text-bg',
            'neutral': 'bg-secondary text-text'
        },
        init() {
            console.log('Toast component initialized');
            // Listen for native window events as fallback
            window.addEventListener('toast', (e) => {
                console.log('Native toast event received:', e.detail);
                const detail = typeof e.detail === 'string' ? { message: e.detail } : e.detail;
                this.message = detail.message || 'Notification';
                this.currentVariant = detail.variant || '{{ $variant }}';
                this.show = true;
                setTimeout(() => this.show = false, 3000);
            });
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
    @toast.window="
        console.log('Alpine @toast.window triggered:', $event.detail);
        const detail = typeof $event.detail === 'string' ? { message: $event.detail } : $event.detail;
        message = detail.message || 'Notification';
        currentVariant = detail.variant || '{{ $variant }}';
        show = true;
        setTimeout(() => show = false, 3000)
    "
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
