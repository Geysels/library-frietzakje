<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Avatar extends Component
{
    public function __construct(
        public ?string $src = null,
        public string $alt = '',
        public string $size = 'md',
        public ?string $fallback = null,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.avatar');
    }
}
