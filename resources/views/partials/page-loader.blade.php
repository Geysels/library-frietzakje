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
    @if ($logo)
        <img src="{{ asset($logo) }}" alt="{{ config('app.name') }}" class="h-16 w-auto animate-pulse">
    @else
        <div class="size-10 animate-spin rounded-full border-2 border-secondary border-t-primary"></div>
    @endif
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
