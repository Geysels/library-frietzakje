<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class NavSection extends Component
{
    public function __construct(
        public ?string $title = null,
    ) {}

    public function render()
    {
        return view('frietzakje::components.nav-section');
    }
}
