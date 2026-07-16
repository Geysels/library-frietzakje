<nav {{ $attributes->class('flex items-center space-x-2 text-sm') }} aria-label="Breadcrumb">
    @if(!empty($items))
        @foreach($items as $index => $item)
            @if($loop->last)
                <span class="text-text/80">{{ $item['label'] }}</span>
            @else
                <a href="{{ $item['url'] }}" class="text-text/60 hover:text-primary transition-colors">{{ $item['label'] }}</a>
                <x-frietzakje-icon name="chevron_right" class="text-text/40" />
            @endif
        @endforeach
    @else
        {{ $slot }}
    @endif
</nav>
