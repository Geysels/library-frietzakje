<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class ButtonGroup extends Component
{
    public function __construct(
        public bool $attached = true,
        public bool $vertical = false,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.button-group');
    }
}
