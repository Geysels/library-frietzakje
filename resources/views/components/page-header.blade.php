<div {{ $attributes->class('mb-8 space-y-4') }}>
    @if (! empty($breadcrumbs))
        <x-frietzakje-breadcrumbs :items="$breadcrumbs" />
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div class="min-w-0 space-y-1">
            <h1 class="truncate">{{ $title }}</h1>

            @if ($description)
                <p class="text-text/60"><small>{{ $description }}</small></p>
            @endif
        </div>

        @isset($actions)
            <div class="flex flex-shrink-0 flex-wrap items-center gap-2">
                {{ $actions }}
            </div>
        @endisset
    </div>
</div>
