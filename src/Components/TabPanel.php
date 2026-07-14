<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class TabPanel extends Component
{
    public function __construct(
        public string $name,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.tab-panel');
    }
}
