@php
    $variantClasses = [
        'primary' => 'bg-primary text-bg',
        'success' => 'bg-success text-bg',
        'danger' => 'bg-danger text-bg',
        'message' => 'bg-message text-bg',
        'neutral' => 'bg-secondary text-text',
    ];

    $varClass = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    {{ $attributes->class('flex items-center justify-between gap-4 px-4 py-3 ' . $varClass) }}
>
    <div class="flex-1">
        {{ $slot }}
    </div>

    @if($dismissible)
        <button @click="show = false" class="flex-shrink-0 opacity-70 hover:opacity-100" aria-label="Dismiss">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</div>
