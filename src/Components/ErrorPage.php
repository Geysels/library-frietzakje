<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

/**
 * A full-page error screen in the suite's voice, styled like the sign-in page.
 *
 * The copy lives here rather than in each app so every app in the suite fails in the same
 * tone — an app only needs `<x-frietzakje-error-page code="404" />` and gets the shared
 * wording, or may pass its own title/message for something app-specific.
 */
class ErrorPage extends Component
{
    /**
     * What each status code says. Dutch, and light-hearted — an error is a bad moment for
     * someone, and a chip-shop joke takes the edge off better than a stack trace does.
     *
     * @var array<int|string, array{string, string}>
     */
    public const COPY = [
        401 => ['Eerst even aanmelden', 'Je moet ingelogd zijn om hier binnen te mogen.'],
        403 => ['Achter de toonbank kom je niet', 'Deze plek is enkel voor het personeel. Je hebt geen toestemming om hier te zijn.'],
        404 => ['Deze pagina ligt niet in de zak', 'We hebben overal gezocht, zelfs onderin de friteuse, maar deze pagina is nergens te vinden. Misschien is ze opgegeten.'],
        405 => ['Zo serveren we dat niet', 'Deze actie kan hier niet op die manier. Ga terug en probeer het opnieuw.'],
        419 => ['Je frietje is koud geworden', 'Je zat te lang stil en je sessie is verlopen. Laad de pagina opnieuw en probeer het nog eens.'],
        429 => ['Niet dringen aan de toog', 'Je gaat wat te snel. Neem even een frietje, adem in, en probeer het zo dadelijk opnieuw.'],
        500 => ['De friteuse is oververhit', 'Er ging iets mis aan onze kant. We zijn de boel aan het afkoelen — probeer het straks nog eens.'],
        503 => ['Even de friteuse aan het kuisen', 'We zijn zo terug. De keuken is heel even dicht voor onderhoud.'],
    ];

    /** Fallback for a code we have no joke for, so an odd status still renders a real page. */
    private const FALLBACK = ['Er liep iets mis', 'Er ging iets mis. Probeer het opnieuw, of ga terug naar de app.'];

    /**
     * Framework defaults that must never reach a user: English boilerplate, or the code's own
     * generic name. A `detail` matching one of these is dropped in favour of the shared copy.
     */
    private const BOILERPLATE = [
        'this action is unauthorized',
        'unauthenticated',
        'forbidden',
        'not found',
        'unauthorized',
        'server error',
        'page expired',
        'too many requests',
        'service unavailable',
        'method not allowed',
    ];

    public string $title;

    public string $message;

    public ?string $detail;

    public function __construct(
        public string $code = '500',
        ?string $title = null,
        ?string $message = null,
        ?string $detail = null,
        public string $homeUrl = '/',
        public string $homeLabel = 'Terug naar de app',
    ) {
        [$defaultTitle, $defaultMessage] = self::COPY[(int) $code] ?? self::FALLBACK;

        $this->title = $title ?? $defaultTitle;
        $this->message = $message ?? $defaultMessage;
        $this->detail = $this->usableDetail($detail);
    }

    /**
     * An app may pass the exception message, which is worth showing when someone wrote it for a
     * human ("Je hebt geen toegang tot Planning.") and worth hiding when the framework generated
     * it. Anything that repeats our own copy is dropped too, so the page never says it twice.
     */
    private function usableDetail(?string $detail): ?string
    {
        $detail = trim((string) $detail);

        if ($detail === '' || $detail === $this->message) {
            return null;
        }

        return in_array(mb_strtolower(rtrim($detail, '.')), self::BOILERPLATE, true) ? null : $detail;
    }

    public function render()
    {
        return view('frietzakje::components.error-page');
    }
}
