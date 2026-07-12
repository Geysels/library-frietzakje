<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Spinner extends Component
{
    public function __construct(
        public string $size = 'md',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.spinner');
    }
}
