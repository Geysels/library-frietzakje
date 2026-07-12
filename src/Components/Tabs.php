<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    public function __construct(
        public string $active = '',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.tabs');
    }
}
