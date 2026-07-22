{{--
    A single nav entry: either a leaf link or — when it has children — an expandable
    sub-group with one level of sub-links. Same collapse/persist behaviour as a group;
    it auto-expands when one of its children is the current page.

    Expects: $node (normalised in components/nav.blade.php).
--}}
@php
    $__hasChildren = ! empty($node['children']);
    $__activeClasses = 'bg-primary/15 text-primary';
    $__idleClasses = 'text-text/85 hover:bg-secondary/40';
@endphp

@if ($__hasChildren)
    @php $__subKey = 'nav-sub-'.\Illuminate\Support\Str::slug($node['label'] ?: 'item'); @endphp
    <li x-data="{
            open: false,
            init() {
                @if ($node['active'])
                    this.open = true;
                @else
                    this.open = localStorage.getItem('{{ $__subKey }}') === '1';
                @endif
            },
            toggle() {
                this.open = ! this.open;
                localStorage.setItem('{{ $__subKey }}', this.open ? '1' : '0');
            },
        }">
        <button type="button"
                @click="toggle()"
                @class([
                    'flex w-full items-center gap-3 rounded-lg px-3 py-2 text-left transition-colors duration-150',
                    $__activeClasses => $node['active'],
                    $__idleClasses => ! $node['active'],
                ])
                :aria-expanded="open"
                aria-controls="{{ $__subKey }}">
            @if ($node['icon'])
                <x-frietzakje-icon :name="$node['icon']" class="text-xl" />
            @endif
            <span class="flex-1 text-sm font-medium">{{ $node['label'] }}</span>
            <x-frietzakje-icon name="expand_more" class="text-base transition-transform duration-200" x-bind:class="open ? 'rotate-180' : ''" />
        </button>

        <ul x-show="open" x-collapse x-cloak id="{{ $__subKey }}" class="mt-1 space-y-1 pl-4">
            @foreach ($node['children'] as $child)
                <li>
                    <a href="{{ $child['href'] }}"
                       @if (function_exists('wire')) wire:navigate @endif
                       @click="sidebarOpen = false"
                       @if ($child['external']) target="_blank" rel="noopener" @endif
                       @class([
                           'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-150',
                           $__activeClasses => $child['active'],
                           $__idleClasses => ! $child['active'],
                       ])
                       aria-current="{{ $child['active'] ? 'page' : 'false' }}">
                        <span class="flex-1">{{ $child['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@else
    <li>
        <a href="{{ $node['href'] }}"
           @if (function_exists('wire')) wire:navigate @endif
           @click="sidebarOpen = false"
           @if ($node['external']) target="_blank" rel="noopener" @endif
           @class([
               'flex items-center gap-3 rounded-lg px-3 py-2 transition-colors duration-150',
               $__activeClasses => $node['active'],
               $__idleClasses => ! $node['active'],
           ])
           aria-current="{{ $node['active'] ? 'page' : 'false' }}">
            @if ($node['icon'])
                <x-frietzakje-icon :name="$node['icon']" class="text-xl" />
            @endif
            <span class="flex-1 text-sm font-medium">{{ $node['label'] }}</span>
            @if ($node['badge'])
                <x-frietzakje-badge variant="neutral" class="ml-auto">{{ $node['badge'] }}</x-frietzakje-badge>
            @endif
        </a>
    </li>
@endif
