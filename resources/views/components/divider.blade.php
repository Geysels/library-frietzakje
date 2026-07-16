@if($text)
    <div {{ $attributes->class('relative flex items-center') }}>
        <div class="flex-grow border-t border-secondary"></div>
        <span class="flex-shrink mx-4 text-text/50 text-sm">{{ $text }}</span>
        <div class="flex-grow border-t border-secondary"></div>
    </div>
@else
    <hr {{ $attributes->class('border-secondary') }}>
@endif
