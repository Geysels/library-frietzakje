<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Radio extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $name = null,
        public ?string $value = null,
    ) {}

    public function render()
    {
        return view('frietzakje::components.radio');
    }
}
