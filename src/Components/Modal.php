<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Two drivers, because the library has to work in apps with and without Livewire:
     *
     *  - `name` — plain Alpine. Open it from anywhere with
     *    $dispatch('open-modal', 'confirm-delete'), close with 'close-modal'.
     *  - `show` — the original Livewire binding against a boolean property, kept so
     *    existing callers keep working.
     *
     * With neither set we fall back to the historical `modalOpen` Livewire property.
     */
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
