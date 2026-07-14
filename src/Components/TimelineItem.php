<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class TimelineItem extends Component
{
    public function __construct(
        public ?string $icon = null,
        public string $variant = 'neutral',
        public ?string $time = null,
        public ?string $title = null,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.timeline-item');
    }
}
