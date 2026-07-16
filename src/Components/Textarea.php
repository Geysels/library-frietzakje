<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Textarea extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $help = null,
        public ?string $error = null,
        public ?string $name = null,
        public int $rows = 4,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.textarea');
    }
}
