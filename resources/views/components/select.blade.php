@php
    $id = $attributes->get('id') ?? ($name ? 'select-'.$name : null);
    $base = 'w-full rounded-md border bg-bg px-3 py-2 transition-colors duration-150'
        .' focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary';
    $borderClass = $error ? 'border-danger' : 'border-secondary';
@endphp

<div class="grid gap-1">
    @if($label)
        <label for="{{ $id }}" class="text-sm">{{ $label }}</label>
    @endif

    <select
        id="{{ $id }}"
        @if($name) name="{{ $name }}" @endif
        {{ $attributes->class($base.' '.$borderClass) }}
    >
        {{ $slot }}
        @foreach($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    @if($help && !$error)
        <small class="text-text/60">{{ $help }}</small>
    @endif
    @if($error)
        <small class="text-danger">{{ $error }}</small>
    @endif
</div>
