<div
    x-data="{ show: false }"
    x-init="show = ! localStorage.getItem('cookie-consent')"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    class="fixed inset-x-0 bottom-0 z-[60] border-t border-secondary bg-bg/95 backdrop-blur-sm"
    role="region"
    aria-label="Cookiemelding"
>
    <div class="mx-auto flex max-w-5xl flex-col gap-3 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <p class="text-sm text-text/80">
            We gebruiken alleen functionele cookies om je aangemeld te houden — geen tracking.
            @if (\Illuminate\Support\Facades\Route::has('legal.cookies'))
                <a href="{{ route('legal.cookies') }}" class="text-primary hover:underline">Meer over cookies</a>.
            @endif
        </p>

        <div class="flex flex-shrink-0 gap-2">
            <button
                type="button"
                @click="localStorage.setItem('cookie-consent', 'declined'); show = false"
                class="rounded-md px-3 py-1.5 text-sm text-text/70 transition-colors hover:bg-secondary/40"
            >
                Weigeren
            </button>
            <button
                type="button"
                @click="localStorage.setItem('cookie-consent', 'accepted'); show = false"
                class="rounded-md bg-primary px-3 py-1.5 text-sm font-semibold text-bg transition-colors hover:bg-primary/90"
            >
                Accepteren
            </button>
        </div>
    </div>
</div>
