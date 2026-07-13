@php
    $id = $attributes->get('id') ?? ($name ? 'datetime-'.$name : uniqid('datetime-'));
    $base = 'w-full rounded-md border bg-bg px-3 py-2 transition-colors duration-150'
        .' focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary';
    $borderClass = $error ? 'border-danger' : 'border-secondary';

    // Mode options: 'datetime', 'date', 'time'
    $mode = $mode ?? 'datetime';

    // Time format: 24hr or 12hr
    $timeFormat = $timeFormat ?? '24hr';

    // Date format (for display)
    $dateFormat = $dateFormat ?? ($mode === 'time' ? 'H:i' : ($mode === 'date' ? 'Y-m-d' : 'Y-m-d H:i'));

    // Enable/disable time picker
    $enableTime = $mode === 'datetime' || $mode === 'time';
    $noCalendar = $mode === 'time';
@endphp

<div class="grid gap-1"
     x-data="{
        picker: null,
        init() {
            this.picker = flatpickr(this.$refs.input, {
                enableTime: {{ $enableTime ? 'true' : 'false' }},
                noCalendar: {{ $noCalendar ? 'true' : 'false' }},
                dateFormat: '{{ $dateFormat }}',
                time_24hr: {{ $timeFormat === '24hr' ? 'true' : 'false' }},
                @if($minDate ?? false)
                minDate: '{{ $minDate }}',
                @endif
                @if($maxDate ?? false)
                maxDate: '{{ $maxDate }}',
                @endif
                @if($defaultDate ?? false)
                defaultDate: '{{ $defaultDate }}',
                @endif
                @if($inline ?? false)
                inline: true,
                @endif
            });
        }
     }"
     x-init="init()">
    @if($label)
        <label for="{{ $id }}" class="text-sm">{{ $label }}</label>
    @endif

    <input
        x-ref="input"
        type="text"
        id="{{ $id }}"
        @if($name) name="{{ $name }}" @endif
        @if($placeholder ?? false) placeholder="{{ $placeholder }}" @endif
        @if($value ?? false) value="{{ $value }}" @endif
        {{ $attributes->except(['mode', 'time-format', 'date-format', 'min-date', 'max-date', 'default-date', 'inline'])->class($base.' '.$borderClass) }}
    >

    @if($help && !$error)
        <small class="text-text/60">{{ $help }}</small>
    @endif
    @if($error)
        <small class="text-danger">{{ $error }}</small>
    @endif
</div>
