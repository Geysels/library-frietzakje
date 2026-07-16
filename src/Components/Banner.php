<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Banner extends Component
{
    public function __construct(
        public string $variant = 'primary',
        public bool $dismissible = true,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.banner');
    }
}
