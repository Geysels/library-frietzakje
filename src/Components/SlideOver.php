<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class SlideOver extends Component
{
    public function __construct(
        public string $name,
        public ?string $title = null,
        public ?string $description = null,
        public string $width = 'max-w-lg',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.slide-over');
    }
}
