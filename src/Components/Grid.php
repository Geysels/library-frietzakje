<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Grid extends Component
{
    public function __construct(
        public string $cols = '1',
        public string $gap = '4',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.grid');
    }
}
