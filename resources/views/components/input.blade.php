@php
    $id = $attributes->get('id') ?? ($name ? 'input-'.$name : null);
    $base = 'w-full rounded-md border bg-bg px-3 py-2 transition-colors duration-150'
        .' focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary';
    $borderClass = $error ? 'border-danger' : 'border-secondary';

    // Passwords are verified byte-for-byte, so the keyboard must never silently rewrite
    // a character. iOS "Smart Punctuation" turns ' into ' and " into ", which would bake a
    // different secret into the hash than the user thinks they typed. Disable it everywhere a
    // password is set or entered. Callers can still override any of these explicitly.
    $hardening = $type === 'password'
        ? ['autocapitalize' => 'none', 'autocorrect' => 'off', 'spellcheck' => 'false']
        : [];
@endphp

<div class="grid gap-1">
    @if ($label)
        <label for="{{ $id }}" class="text-sm">{{ $label }}</label>
    @endif

    <input
        id="{{ $id }}"
        type="{{ $type }}"
        @if ($name) name="{{ $name }}" @endif
        {{ $attributes->merge($hardening)->class($base.' '.$borderClass) }}
    >

    @if ($help && ! $error)
        <small class="text-text/60">{{ $help }}</small>
    @endif
    @if ($error)
        <small class="text-danger">{{ $error }}</small>
    @endif
</div>
