<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Skeleton extends Component
{
    public function __construct(
        public string $variant = 'text',
        public int $lines = 3,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.skeleton');
    }
}
