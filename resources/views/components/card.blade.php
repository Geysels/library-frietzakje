@php
    $classes = 'rounded-lg border border-secondary bg-bg/40 backdrop-blur-sm';
    if ($padded) { $classes .= ' p-5'; }
    if ($hoverable) { $classes .= ' transition-colors duration-150 hover:border-primary/60'; }
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
