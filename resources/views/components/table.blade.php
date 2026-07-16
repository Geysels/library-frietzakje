@php
    $classes = 'fz-table w-full text-left border-collapse';
    if ($striped) $classes .= ' striped';
    if ($hoverable) $classes .= ' hoverable';
@endphp

<div class="fz-table-scroll overflow-x-auto rounded-lg border border-secondary">
    <table {{ $attributes->class($classes) }}>
        {{ $slot }}
    </table>
</div>
