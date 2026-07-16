@php
    $id = $attributes->get('id') ?? ($name ? 'input-'.$name : null);
    $base = 'w-full rounded-md border bg-bg py-2 transition-colors duration-150'
        .' focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary';
    $borderClass = $error ? 'border-danger' : 'border-secondary';
    $paddingClass = ($icon ? 'pl-10' : 'pl-3').' '.($trailingIcon ? 'pr-10' : 'pr-3');

    $hardening = $type === 'password'
        ? ['autocapitalize' => 'none', 'autocorrect' => 'off', 'spellcheck' => 'false']
        : [];
@endphp

@if ($floating ?? false)
    <div class="grid gap-1">
        <div class="relative">
            <input
                id="{{ $id }}"
                type="{{ $type }}"
                @if ($name) name="{{ $name }}" @endif
                placeholder=" "
                {{ $attributes->merge($hardening)->class(
                    'fz-float-input w-full rounded-md border bg-bg px-3 pt-5 pb-1.5 text-base transition-colors duration-150'
                    .' focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary'
                    .($trailingIcon ? ' pr-10' : '').' '.$borderClass
                ) }}
            >

            @if ($label)
                <label for="{{ $id }}" class="fz-float-label">{{ $label }}</label>
            @endif

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
@else
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
@endif
