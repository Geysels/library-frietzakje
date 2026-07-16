<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Divider extends Component
{
    public function __construct(
        public ?string $text = null,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.divider');
    }
}
