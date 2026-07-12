<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $type = 'text',
        public ?string $label = null,
        public ?string $help = null,
        public ?string $error = null,
        public ?string $name = null,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.input');
    }
}
