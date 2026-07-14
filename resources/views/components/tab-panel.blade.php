{{-- Reads `activeTab` from the enclosing <x-frietzakje-tabs> scope. --}}
<div
    x-show="activeTab === '{{ $name }}'"
    x-cloak
    role="tabpanel"
    {{ $attributes }}
>
    {{ $slot }}
</div>
