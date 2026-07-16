<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public string $variant = 'neutral',
        public string $size = 'md',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.badge');
    }
}
