<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Accordion extends Component
{
    public function __construct(
        public string $title = '',
        public bool $open = false,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.accordion');
    }
}
