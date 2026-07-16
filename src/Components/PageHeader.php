<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class PageHeader extends Component
{
    /**
     * @param  array<int, array{label: string, url?: string}>  $breadcrumbs
     */
    public function __construct(
        public string $title,
        public ?string $description = null,
        public array $breadcrumbs = [],
    ) {}

    public function render()
    {
        return view('frietzakje::components.page-header');
    }
}
