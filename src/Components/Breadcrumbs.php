<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public function __construct(
        public array $items = [],
    ) {
    }

    public function render()
    {
        return view('frietzakje::components.breadcrumbs');
    }
}
