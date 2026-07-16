<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Link extends Component
{
    public function __construct(
        public string $href = '#',
        public string $variant = 'default',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.link');
    }
}
