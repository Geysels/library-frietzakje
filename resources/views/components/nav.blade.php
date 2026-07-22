@props(['sections' => []])

@php
    $__user = auth()->user();

    // The current path, normalised to a leading slash and no trailing slash. Determined here so
    // the caller never has to pass it.
    $__current = '/'.trim(request()->path(), '/');

    // Resolve a node's href from an explicit url or a named route.
    $__href = function (array $node): string {
        if (isset($node['route']) && \Illuminate\Support\Facades\Route::has($node['route'])) {
            return route($node['route'], $node['params'] ?? []);
        }

        return $node['url'] ?? '#';
    };

    // Is this node the current page? A legacy `active` request pattern wins; otherwise the
    // current path must equal the node's link path or sit underneath it (active-trail).
    $__isActive = function (array $node) use ($__current, $__href): bool {
        if (isset($node['active'])) {
            return request()->is($node['active']);
        }

        $href = $__href($node);

        if ($href === '' || $href === '#') {
            return false;
        }

        $path = parse_url($href, PHP_URL_PATH) ?: $href;
        $path = '/'.trim($path, '/');

        if ($path === '/') {
            return $__current === '/';
        }

        return $__current === $path || \Illuminate\Support\Str::startsWith($__current, $path.'/');
    };

    // Build a clean, gated, active-resolved tree. Presentation lives in the template below.
    $__groups = [];

    foreach ($sections as $section) {
        // Owner-only group gate (legacy key, honoured for backwards compatibility).
        if (($section['owner'] ?? false) && ! ($__user?->isOwner())) {
            continue;
        }

        $groupItems = [];

        foreach ($section['items'] ?? [] as $item) {
            // Per-item owner gate.
            if (($item['owner'] ?? false) && ! ($__user?->isOwner())) {
                continue;
            }

            // Membership gate: an item may require the user to belong to a suite app.
            if (isset($item['app'])
                && ! ($__user && method_exists($__user, 'belongsToApp') && $__user->belongsToApp($item['app']))) {
                continue;
            }

            // One level of sub-links. Children never have children of their own.
            $children = [];
            $childActive = false;

            foreach ($item['children'] ?? [] as $child) {
                $ca = $__isActive($child);
                $childActive = $childActive || $ca;

                $children[] = [
                    'label' => $child['label'] ?? '',
                    'href' => $__href($child),
                    'active' => $ca,
                    'external' => ! empty($child['external']),
                ];
            }

            $hasChildren = $children !== [];
            $active = $hasChildren ? $childActive : $__isActive($item);

            $groupItems[] = [
                'label' => $item['label'] ?? '',
                'icon' => $item['icon'] ?? null,
                'href' => $hasChildren ? null : $__href($item),
                'active' => $active,
                'badge' => $item['badge'] ?? null,
                'external' => ! empty($item['external']),
                'children' => $children,
            ];
        }

        if ($groupItems === []) {
            continue;
        }

        // A null label/title means an un-grouped block: always open, no collapsing header.
        $label = $section['label'] ?? $section['title'] ?? null;

        $__groups[] = [
            'label' => $label,
            'icon' => $section['icon'] ?? null,
            'active' => collect($groupItems)->contains(fn ($i) => $i['active']),
            'items' => $groupItems,
            // Stable per-nav key so localStorage remembers this exact group across navigations.
            'key' => 'nav-'.\Illuminate\Support\Str::slug($label ?? 'groep').'-'.count($__groups),
        ];
    }

    // Single-open accordion: only one group is open at a time. The group containing the current
    // page opens by default; otherwise the last-opened group is restored client-side.
    $__active = collect($__groups)->firstWhere('active', true);
    $__activeKey = $__active['key'] ?? null;
@endphp

<div {{ $attributes->class('space-y-4') }}
     x-data="{
         openKey: '{{ $__activeKey }}' || null,
         init() {
             // No group is active on this page → restore the last-opened one.
             if (! this.openKey) {
                 this.openKey = localStorage.getItem('nav-open') || null;
             }
         },
         toggle(key) {
             // Accordion: opening a group closes whichever was open.
             this.openKey = (this.openKey === key) ? null : key;
             localStorage.setItem('nav-open', this.openKey ?? '');
         },
     }">
    @foreach ($__groups as $group)
        @if ($group['label'] === null)
            {{-- Un-grouped: render the items directly, always visible. --}}
            <ul class="space-y-1">
                @foreach ($group['items'] as $item)
                    @include('frietzakje::components.partials.nav-node', ['node' => $item])
                @endforeach
            </ul>
        @else
            <div>
                <button type="button"
                        @click="toggle('{{ $group['key'] }}')"
                        class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-text/60 transition-colors hover:bg-secondary/40 hover:text-text/80"
                        :aria-expanded="openKey === '{{ $group['key'] }}'"
                        aria-controls="{{ $group['key'] }}">
                    @if ($group['icon'])
                        <x-frietzakje-icon :name="$group['icon']" class="text-lg" />
                    @endif
                    <span class="flex-1">{{ $group['label'] }}</span>
                    <x-frietzakje-icon name="expand_more" class="text-base transition-transform duration-200" x-bind:class="openKey === '{{ $group['key'] }}' ? 'rotate-180' : ''" />
                </button>

                <ul x-show="openKey === '{{ $group['key'] }}'" x-collapse x-cloak id="{{ $group['key'] }}" class="mt-1 space-y-1">
                    @foreach ($group['items'] as $item)
                        @include('frietzakje::components.partials.nav-node', ['node' => $item])
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
</div>
