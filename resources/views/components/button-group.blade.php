@php
    // Attached: join the buttons into a segmented control. We strip every child's radius (important,
    // since the button sets its own rounded-md) and round only the outer corners, then draw a hair
    // seam between them with divide-*. A focused child is lifted so its ring isn't clipped by a
    // neighbour. Not attached: a plain gap'd toolbar.
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
