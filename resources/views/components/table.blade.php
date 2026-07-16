@php
    // `fz-table` scopes the styles in the stylesheet to this component. Without it the
    // rules leak onto every <table> on the page.
    $classes = 'fz-table w-full text-left border-collapse';
    if ($striped) $classes .= ' striped';
    if ($hoverable) $classes .= ' hoverable';
@endphp

<div class="fz-table-scroll overflow-x-auto rounded-lg border border-secondary">
    <table {{ $attributes->class($classes) }}>
        {{ $slot }}
    </table>
</div>
