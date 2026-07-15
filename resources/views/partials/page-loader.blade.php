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
     class="fixed inset-0 z-[200] flex flex-col items-center justify-center gap-6 bg-bg transition-opacity duration-300">
    {{-- A vertical splash: logo on top, the wordmark below it, then the spinner and
         its label at the bottom. --}}
    @if ($logo)
        <img src="{{ asset($logo) }}" alt="{{ config('app.name') }}" class="h-32 w-auto animate-pulse sm:h-40">
    @endif

    <span class="wordmark text-3xl text-primary sm:text-4xl">{{ config('app.name') }}</span>

    <div class="mt-2 flex items-center gap-3 text-text/60">
        <x-frietzakje-spinner size="md" variant="primary" />
        <span class="text-sm">Laden…</span>
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
