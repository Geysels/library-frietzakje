<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class NavItem extends Component
{
    public function __construct(
        public string $href,
        public ?string $icon = null,
        public bool $active = false,
        public ?string $badge = null,
    ) {}

    public function render()
    {
        return view('frietzakje::components.nav-item');
    }
}
