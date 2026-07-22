<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

/**
 * A self-contained, collapsible grouped sidebar. Give it a structured `:sections`
 * array and it renders the whole menu: groups that collapse/expand, one level of
 * sub-links, active-trail auto-expansion and persisted open/closed state.
 *
 * It reads the current path itself (request()->path()), so the caller never passes it.
 * The new shape uses `label` + `icon` + `items`, but the legacy `title` + `items` shape
 * (and per-item `owner`/`app`/`route`/`active` gating keys) still render unchanged.
 */
class Nav extends Component
{
    /**
     * @param  array<int, array<string, mixed>>  $sections
     */
    public function __construct(
        public array $sections = [],
    ) {}

    public function render()
    {
        return view('frietzakje::components.nav');
    }
}
