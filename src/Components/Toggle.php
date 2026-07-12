<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Toggle extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $name = null,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.toggle');
    }
}
