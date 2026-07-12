@php
    $iconPaths = [
        'calendar' => 'M6.75 3v2.25M17.25 3v2.25M3.75 18.75V8.25a3 3 0 013-3h12a3 3 0 013 3v10.5m-19.5 0a3 3 0 003 3h13.5a3 3 0 003-3m-19.5 0V12a3 3 0 013-3h13.5a3 3 0 013 3v6.75',
        'users' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
        'clock' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
        'inbox' => 'M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z',
    ];
    $path = $iconPaths[$icon] ?? $iconPaths['calendar'];
@endphp

<div {{ $attributes->class('grid place-items-center gap-3 rounded-lg border border-dashed border-secondary p-10 text-center') }}>
    <div class="grid size-12 place-items-center rounded-full bg-secondary/40 text-text/60">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
        </svg>
    </div>
    @if ($title)
        <p class="font-display font-semibold">{{ $title }}</p>
    @endif
    @if ($description)
        <p class="max-w-md text-text/70"><small>{{ $description }}</small></p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="mt-1">{{ $slot }}</div>
    @endif
</div>
