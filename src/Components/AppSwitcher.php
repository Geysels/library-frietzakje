<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

/**
 * The launcher that turns several standalone deployments into one product.
 *
 * Each app in the suite runs on its own — own repo, own database, own deploy — so the
 * only thing that can make them feel like one app is that they all wear the same shell
 * and can all reach each other. This is that reach.
 *
 * Reads the registry from config('frietzakje-ui.apps') and marks the entry whose `key`
 * matches config('frietzakje-ui.app') as the current one, so every app knows where it
 * sits in the suite without being told twice.
 */
class AppSwitcher extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $apps;

    public ?string $current;

    /** Which edge the dropdown opens from — 'left' (default) or 'right'. */
    public string $align;

    public function __construct(?array $apps = null, ?string $current = null, string $align = 'left')
    {
        $this->apps = $apps ?? config('frietzakje-ui.apps', []);
        $this->current = $current ?? config('frietzakje-ui.app');
        $this->align = $align === 'right' ? 'right' : 'left';
    }

    public function isCurrent(array $app): bool
    {
        return $this->current !== null && ($app['key'] ?? null) === $this->current;
    }

    /** The app we are running, if it is in the registry at all. */
    public function currentApp(): ?array
    {
        foreach ($this->apps as $app) {
            if ($this->isCurrent($app)) {
                return $app;
            }
        }

        return null;
    }

    /**
     * With nothing to switch to, a switcher is a button that does nothing. Hide it rather
     * than showing the user a launcher containing only the app they are already in.
     */
    public function shouldRender(): bool
    {
        return count($this->apps) > 1;
    }

    public function render()
    {
        return view('frietzakje::components.app-switcher');
    }
}
