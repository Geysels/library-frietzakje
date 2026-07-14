<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public string $align = 'right',
        public string $width = 'w-56',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.dropdown');
    }
}
