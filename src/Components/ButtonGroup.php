<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class ButtonGroup extends Component
{
    public function __construct(
        // Attached: buttons are joined into one segmented control (shared edges, only the outer
        // corners rounded). Off: a plain toolbar row/column with a gap between buttons.
        public bool $attached = true,
        public bool $vertical = false,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.button-group');
    }
}
