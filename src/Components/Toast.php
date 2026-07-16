<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Toast extends Component
{
    public function __construct(
        public string $variant = 'primary',
        public string $position = 'top-right',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.toast');
    }
}
