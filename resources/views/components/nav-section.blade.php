@props(['title' => null])

<div class="space-y-1">
    @if ($title)
        <h3 class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-text/60">{{ $title }}</h3>
    @endif
    <ul class="space-y-1">
        {{ $slot }}
    </ul>
</div>
