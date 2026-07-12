<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public bool $hoverable = false,
        public bool $padded = true,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.card');
    }
}
