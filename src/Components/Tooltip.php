<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Tooltip extends Component
{
    public function __construct(
        public string $text,
        public string $position = 'top',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.tooltip');
    }
}
