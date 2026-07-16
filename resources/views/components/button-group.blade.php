@php
    if ($attached) {
        $layout = $vertical
            ? 'inline-flex flex-col divide-y divide-bg/20 [&>*]:rounded-none! [&>*:first-child]:rounded-t-md! [&>*:last-child]:rounded-b-md! [&>*:focus-visible]:relative [&>*:focus-visible]:z-10'
            : 'inline-flex divide-x divide-bg/20 [&>*]:rounded-none! [&>*:first-child]:rounded-l-md! [&>*:last-child]:rounded-r-md! [&>*:focus-visible]:relative [&>*:focus-visible]:z-10';
    } else {
        $layout = $vertical ? 'inline-flex flex-col gap-2' : 'inline-flex flex-wrap gap-2';
    }
@endphp

<div role="group" {{ $attributes->class($layout) }}>
    {{ $slot }}
</div>
