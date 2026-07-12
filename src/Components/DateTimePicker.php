<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class DateTimePicker extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $help = null,
        public ?string $error = null,
        public ?string $name = null,
        public string $type = 'date',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.date-time-picker');
    }
}
