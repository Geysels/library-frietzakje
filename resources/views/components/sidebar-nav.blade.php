{{-- Renders the sidebar from a data structure so every app in the suite gets an identical
     menu — apps supply the entries, the library owns the rendering.

     $sections: array of sections, each:
       [
         'title'  => 'Beheer',          // optional section heading
         'owner'  => true,              // optional — section shown to owners only
         'items'  => [
           [
             'label'    => 'Gebruikers',
             'icon'     => 'group',      // Material Symbols name (optional)
             'route'    => 'admin.users' // OR 'url' => '/path'
             'params'   => [],           // optional route params
             'active'   => 'admin/*',    // optional request()->is() pattern
             'owner'    => true,         // optional — item shown to owners only
             'external' => true,         // optional — opens in a new tab
           ],
         ],
       ]
--}}
@props(['sections' => []])

@php $__user = auth()->user(); @endphp

<div class="space-y-6">
    @foreach ($sections as $section)
        @php
            $ownerOnly = $section['owner'] ?? false;
            $items = collect($section['items'] ?? [])
                ->reject(fn ($i) => ($i['owner'] ?? false) && ! ($__user?->isOwner()));
        @endphp

        @if (! ($ownerOnly && ! $__user?->isOwner()) && $items->isNotEmpty())
            <x-frietzakje-nav-section :title="$section['title'] ?? null">
                @foreach ($items as $item)
                    @php
                        $href = isset($item['route'])
                            ? route($item['route'], $item['params'] ?? [])
                            : ($item['url'] ?? '#');
                        $active = isset($item['active']) && request()->is($item['active']);
                    @endphp
                    <x-frietzakje-nav-item
                        :href="$href"
                        :icon="$item['icon'] ?? null"
                        :active="$active"
                        :target="! empty($item['external']) ? '_blank' : null"
                    >{{ $item['label'] ?? '' }}</x-frietzakje-nav-item>
                @endforeach
            </x-frietzakje-nav-section>
        @endif
    @endforeach
</div>
