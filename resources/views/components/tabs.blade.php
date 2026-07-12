@php
    // Tabs should be used with x-data="{ activeTab: 'tab1' }" in parent
@endphp

<div {{ $attributes->class('border-b border-secondary') }} role="tablist">
    {{ $slot }}
</div>
