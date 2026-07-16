<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Stepper extends Component
{
    /**
     * @param  array<int, array{label: string, description?: string}>  $steps
     * @param  int  $current  1-based index of the step in progress.
     */
    public function __construct(
        public array $steps = [],
        public int $current = 1,
        public string $orientation = 'horizontal',
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.stepper');
    }
}
