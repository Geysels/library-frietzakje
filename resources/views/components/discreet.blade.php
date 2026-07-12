{{-- Wraps a sensitive value (wage, loonkost). Blurred whenever discretion mode is on,
     via the `.privacy .sensitive` CSS rule toggled by the single nav toggle — no
     per-element JS, so it can never get stuck half-blurred. --}}
<span {{ $attributes->class('sensitive inline-block align-middle') }}>{{ $slot }}</span>
