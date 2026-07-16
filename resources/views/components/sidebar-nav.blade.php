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
