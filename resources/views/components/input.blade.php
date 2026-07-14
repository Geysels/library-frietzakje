@php
    $id = $attributes->get('id') ?? ($name ? 'input-'.$name : null);
    $base = 'w-full rounded-md border bg-bg py-2 transition-colors duration-150'
        .' focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary';
    $borderClass = $error ? 'border-danger' : 'border-secondary';

    // Leave room for whichever icons are actually there, so the text never runs under one.
    $paddingClass = ($icon ? 'pl-10' : 'pl-3').' '.($trailingIcon ? 'pr-10' : 'pr-3');

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

    <div class="relative">
        @if ($icon)
            <x-frietzakje-icon
                :name="$icon"
                class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xl text-text/40"
            />
        @endif

        <input
            id="{{ $id }}"
            type="{{ $type }}"
            @if ($name) name="{{ $name }}" @endif
            {{ $attributes->merge($hardening)->class($base.' '.$paddingClass.' '.$borderClass) }}
        >

        @if ($trailingIcon)
            <x-frietzakje-icon
                :name="$trailingIcon"
                class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xl text-text/40"
            />
        @endif
    </div>

    @if ($help && ! $error)
        <small class="text-text/60">{{ $help }}</small>
    @endif
    @if ($error)
        <small class="text-danger">{{ $error }}</small>
    @endif
</div>
