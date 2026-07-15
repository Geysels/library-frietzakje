{{-- Covers the page until the webfonts (including the icon font) are ready, so a visitor
     never sees icon ligature text or a half-painted screen — most noticeable on slow
     connections. Plain inline script so it runs before Alpine; self-removes, with a safety
     timeout so it can never trap the page. app.css is render-blocking in <head>, so this is
     already styled on first paint. --}}
@php
    $logo = collect(['images/logo.png', 'logo.svg', 'logo.png'])
        ->first(fn ($p) => file_exists(public_path($p)));
@endphp

<div id="page-loader"
     class="fixed inset-0 z-[200] flex items-center justify-center bg-bg transition-opacity duration-300">
    {{-- A spinning ring wraps the mark: the ring turns, the logo sits (and gently
         pulses) at its centre. Falls back to just the ring when there's no logo. --}}
    <div class="relative flex size-24 items-center justify-center">
        <div class="absolute inset-0 animate-spin rounded-full border-[3px] border-secondary/50 border-t-primary"></div>
        @if ($logo)
            <img src="{{ asset($logo) }}" alt="{{ config('app.name') }}" class="h-14 w-auto animate-pulse">
        @endif
    </div>
</div>

<script>
    (function () {
        var hide = function () {
            var el = document.getElementById('page-loader');
            if (! el) return;
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 350);
        };
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(hide);
        } else {
            window.addEventListener('load', hide);
        }
        setTimeout(hide, 4000); // safety: never leave the loader up
    })();
</script>
