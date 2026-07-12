<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public string $show = 'modalOpen',
        public string $maxWidth = 'max-w-md',
        public ?string $title = null,
        public string $closeMethod = 'closeModal',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.modal');
    }
}
