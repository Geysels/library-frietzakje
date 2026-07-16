@php
    $bars = [
        'neutral'   => 'bg-text/25',
        'primary'   => 'bg-primary',
        'secondary' => 'bg-secondary',
        'success'   => 'bg-success',
        'warning'   => 'bg-warning',
        'danger'    => 'bg-danger',
        'message'   => 'bg-message',
        'accent'    => 'bg-accent',
        'accent-2'  => 'bg-accent-2',
    ];
@endphp

<div {{ $attributes->class('space-y-3') }}>
    <div class="flex items-end gap-2" style="height: {{ $height }}px">
        @foreach ($series as $datum)
            @php
                $barClass = $bars[$datum['variant'] ?? $variant] ?? $bars['primary'];
            @endphp

            <div class="group flex h-full flex-1 flex-col justify-end gap-2">
                <span @class([
                    'text-center font-display text-xs font-semibold text-text opacity-0 transition-opacity duration-150 group-hover:opacity-100',
                    'sensitive' => $sensitive,
                ])>{{ $formatted($datum) }}</span>

                <div
                    class="{{ $barClass }} w-full rounded-t transition-all duration-300 ease-out group-hover:brightness-110"
                    style="height: {{ $percentFor($datum) }}%"
                    role="img"
                    aria-label="{{ $datum['label'] }}: {{ $formatted($datum) }}"
                ></div>
            </div>
        @endforeach
    </div>

    <div class="flex gap-2">
        @foreach ($series as $datum)
            <span class="flex-1 text-center text-xs text-text/50">{{ $datum['label'] }}</span>
        @endforeach
    </div>
</div>
