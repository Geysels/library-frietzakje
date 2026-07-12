@php
    $base = 'w-full text-left border-collapse';
    $classes = $base;
    if ($striped) $classes .= ' striped';
    if ($hoverable) $classes .= ' hoverable';
@endphp

<div class="overflow-x-auto rounded-lg border border-secondary">
    <table {{ $attributes->class($classes) }}>
        {{ $slot }}
    </table>
</div>

<style>
    table thead {
        background-color: var(--color-secondary);
    }
    table th {
        padding: 0.75rem 1rem;
        font-family: var(--font-display);
        font-weight: 600;
        font-size: var(--text-small);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--color-secondary);
    }
    table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid rgba(48, 48, 48, 0.5);
    }
    table tbody tr:last-child td {
        border-bottom: none;
    }
    table.striped tbody tr:nth-child(even) {
        background-color: rgba(48, 48, 48, 0.3);
    }
    table.hoverable tbody tr:hover {
        background-color: rgba(254, 219, 0, 0.05);
    }
</style>
