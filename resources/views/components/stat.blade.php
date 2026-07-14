@php
    $iconColors = [
        'primary' => 'text-primary',
        'success' => 'text-success',
        'danger' => 'text-danger',
        'message' => 'text-message',
        'accent-2' => 'text-accent-2',
        'neutral' => 'text-text/60',
    ];

    $iconColor = $iconColors[$variant] ?? $iconColors['primary'];
    $tag = $href ? 'a' : 'div';
@endphp

<x-frietzakje-card :hoverable="(bool) $href" {{ $attributes }}>
    <{{ $tag }} @if ($href) href="{{ $href }}" @endif class="block space-y-3">
        <div class="flex items-start justify-between gap-3">
            <span class="text-sm text-text/60">{{ $label }}</span>

            @if ($icon)
                <x-frietzakje-icon :name="$icon" class="text-2xl {{ $iconColor }}" />
            @endif
        </div>

        <p class="font-display text-3xl font-bold tracking-tight">
            @if ($sensitive)
                <x-frietzakje-discreet>{{ $value }}{{ $slot }}</x-frietzakje-discreet>
            @else
                {{ $value }}{{ $slot }}
            @endif
        </p>

        @if ($trend || $caption)
            <div class="flex items-center gap-2">
                @if ($trend)
                    <x-frietzakje-badge :variant="$trendVariant()">
                        <x-frietzakje-icon :name="$trendIcon()" class="text-sm" />
                        {{ $trend }}
                    </x-frietzakje-badge>
                @endif

                @if ($caption)
                    <span class="text-xs text-text/60">{{ $caption }}</span>
                @endif
            </div>
        @endif
    </{{ $tag }}>
</x-frietzakje-card>
