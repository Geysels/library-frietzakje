@php
    $id = $attributes->get('id') ?? ($name ? 'datetime-'.$name : uniqid('datetime-'));
    $base = 'w-full rounded-md border bg-bg px-3 py-2 transition-colors duration-150'
        .' focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary';
    $borderClass = $error ? 'border-danger' : 'border-secondary';

    $mode       = $mode ?? 'datetime';
    $timeFormat = $timeFormat ?? '24hr';
    $dateFormat = $dateFormat ?? ($mode === 'time' ? 'H:i' : ($mode === 'date' ? 'Y-m-d' : 'Y-m-d H:i'));

    $enableTime = $mode === 'datetime' || $mode === 'time';
    $noCalendar = $mode === 'time';

    $flatpickrOptions = [
        'enableTime' => $enableTime,
        'noCalendar' => $noCalendar,
        'dateFormat' => $dateFormat,
        'time_24hr'  => $timeFormat === '24hr',
    ];

    if ($minDate ?? false) {
        $flatpickrOptions['minDate'] = $minDate;
    }
    if ($maxDate ?? false) {
        $flatpickrOptions['maxDate'] = $maxDate;
    }
    if ($defaultDate ?? false) {
        $flatpickrOptions['defaultDate'] = $defaultDate;
    }
    if ($inline ?? false) {
        $flatpickrOptions['inline'] = true;
    }

    $flatpickrOptionsJson = json_encode($flatpickrOptions);
@endphp

<div class="grid gap-1"
     x-data="{ picker: null }"
     x-init="picker = flatpickr($refs.input, JSON.parse($el.dataset.options))"
     data-options="{{ $flatpickrOptionsJson }}">
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
