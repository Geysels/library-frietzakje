<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    /**
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
