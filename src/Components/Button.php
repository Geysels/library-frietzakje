<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $variant = 'primary',
        public string $size = 'md',
        public ?string $href = null,
        public string $type = 'button',
        public ?string $icon = null,
        // Strip the ripple, hover and transition — a completely static button.
        public bool $noAnimation = false,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.button');
    }
}
