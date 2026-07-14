<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class DropdownItem extends Component
{
    public function __construct(
        public ?string $href = null,
        public ?string $icon = null,
        public string $variant = 'default',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.dropdown-item');
    }
}
