<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    /**
     * Two ways to drive this:
     *
     *  - Pass `:tabs` and the component owns its own Alpine state, renders the tab
     *    buttons, and shows the matching <x-frietzakje-tab-panel> children.
     *  - Pass nothing and it degrades to a bare tablist you fill yourself, which is
     *    what the original component did.
     *
     * @param  array<int, array{name: string, label: string, icon?: string, badge?: string}>  $tabs
     */
    public function __construct(
        public array $tabs = [],
        public string $active = '',
    ) {
    }

    public function initialTab(): string
    {
        if ($this->active !== '') {
            return $this->active;
        }

        return $this->tabs[0]['name'] ?? '';
    }

    public function render()
    {
        return view('frietzakje::components.tabs');
    }
}
