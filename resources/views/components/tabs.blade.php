@if (empty($tabs))
    <div {{ $attributes->class('flex gap-1 overflow-x-auto border-b border-secondary') }} role="tablist">
        {{ $slot }}
    </div>
@else
    <div x-data="{ activeTab: '{{ $initialTab() }}' }" {{ $attributes }}>
        <div class="flex gap-1 overflow-x-auto border-b border-secondary" role="tablist">
            @foreach ($tabs as $tab)
                <button
                    type="button"
                    role="tab"
                    @click="activeTab = '{{ $tab['name'] }}'"
                    :aria-selected="activeTab === '{{ $tab['name'] }}' ? 'true' : 'false'"
                    :class="activeTab === '{{ $tab['name'] }}'
                        ? 'border-primary text-primary'
                        : 'border-transparent text-text/60 hover:text-text'"
                    class="-mb-px flex items-center gap-2 whitespace-nowrap border-b-2 px-4 py-2.5 font-display text-sm font-semibold transition-colors duration-150"
                >
                    @if (! empty($tab['icon']))
                        <x-frietzakje-icon :name="$tab['icon']" class="text-lg" />
                    @endif

                    {{ $tab['label'] }}

                    @if (! empty($tab['badge']))
                        <x-frietzakje-badge variant="neutral" size="sm">{{ $tab['badge'] }}</x-frietzakje-badge>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="pt-6">
            {{ $slot }}
        </div>
    </div>
@endif
