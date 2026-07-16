<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $help = null,
        public ?string $error = null,
        public ?string $name = null,
        public array $options = [],
    ) {}

    public function render()
    {
        return view('frietzakje::components.select');
    }
}
