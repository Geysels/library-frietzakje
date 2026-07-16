<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Container extends Component
{
    public function __construct(
        public string $size = 'default',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.container');
    }
}
