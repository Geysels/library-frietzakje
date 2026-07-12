<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class EmptyState extends Component
{
    public function __construct(
        public string $title = '',
        public ?string $description = null,
        public string $icon = 'calendar',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.empty-state');
    }
}
