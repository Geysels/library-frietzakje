<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public ?string $name = null,
        public ?string $show = null,
        public string $maxWidth = 'max-w-md',
        public ?string $title = null,
        public ?string $description = null,
        public string $closeMethod = 'closeModal',
    ) {
        if ($this->name === null && $this->show === null) {
            $this->show = 'modalOpen';
        }
    }

    public function usesLivewire(): bool
    {
        return $this->name === null;
    }

    public function render()
    {
        return view('frietzakje::components.modal');
    }
}
