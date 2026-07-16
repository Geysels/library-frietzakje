<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public string $variant = 'info',
        public bool $dismissible = false,
        public ?string $title = null,
        public ?string $icon = null,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.alert');
    }
}
