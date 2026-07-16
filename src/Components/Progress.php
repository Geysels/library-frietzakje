<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Progress extends Component
{
    public function __construct(
        public int $value = 0,
        public int $max = 100,
        public string $variant = 'primary',
        public bool $showLabel = false,
        public bool $inside = false,
        public bool $animated = false,
        public string $format = 'percent',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.progress');
    }
}
