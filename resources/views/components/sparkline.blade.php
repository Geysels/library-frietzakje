@php
    $strokes = [
        'primary' => 'stroke-primary',
        'success' => 'stroke-success',
        'danger' => 'stroke-danger',
        'message' => 'stroke-message',
        'accent-2' => 'stroke-accent-2',
    ];

    $fills = [
        'primary' => 'fill-primary/15',
        'success' => 'fill-success/15',
        'danger' => 'fill-danger/15',
        'message' => 'fill-message/15',
        'accent-2' => 'fill-accent-2/15',
    ];

    $stroke = $strokes[$variant] ?? $strokes['primary'];
    $fill = $fills[$variant] ?? $fills['primary'];
@endphp

@if (count($series) > 1)
    <svg
        viewBox="0 0 {{ $width }} {{ $height }}"
        preserveAspectRatio="none"
        {{ $attributes->class('w-full') }}
        style="height: {{ $height }}px"
        aria-hidden="true"
    >
        @if ($area)
            <path d="{{ $areaPath() }}" class="{{ $fill }}" stroke="none" />
        @endif

        <polyline
            points="{{ $polyline() }}"
            fill="none"
            class="{{ $stroke }}"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            vector-effect="non-scaling-stroke"
        />
    </svg>
@endif
