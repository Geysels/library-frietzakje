<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class AppSwitcher extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $apps;

    public ?string $current;

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

    public function currentApp(): ?array
    {
        foreach ($this->apps as $app) {
            if ($this->isCurrent($app)) {
                return $app;
            }
        }

        return null;
    }

    public function shouldRender(): bool
    {
        return count($this->apps) > 1;
    }

    public function render()
    {
        return view('frietzakje::components.app-switcher');
    }
}
