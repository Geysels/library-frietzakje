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
        public ?string $placeholder = null,
        public ?string $value = null,
        public string $mode = 'datetime',
        public string $timeFormat = '24hr',
        public ?string $dateFormat = null,
        public ?string $minDate = null,
        public ?string $maxDate = null,
        public ?string $defaultDate = null,
        public bool $inline = false,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.date-time-picker');
    }
}
