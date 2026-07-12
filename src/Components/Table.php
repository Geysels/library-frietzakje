<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        public bool $striped = false,
        public bool $hoverable = true,
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.table');
    }
}
