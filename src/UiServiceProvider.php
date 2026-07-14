<?php

namespace Frietzakje\Ui;

use Illuminate\Support\ServiceProvider;

class UiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load Blade components with frietzakje:: namespace
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'frietzakje');

        // Publish CSS assets
        $this->publishes([
            __DIR__.'/../resources/css' => public_path('vendor/frietzakje/ui'),
        ], 'frietzakje-ui-assets');

        // Publish views for customization
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/frietzakje'),
        ], 'frietzakje-ui-views');

        // Publish config
        $this->publishes([
            __DIR__.'/../config/frietzakje-ui.php' => config_path('frietzakje-ui.php'),
        ], 'frietzakje-ui-config');

        // Register Blade component namespace
        $this->loadViewComponentsAs('frietzakje', [
            Components\Accordion::class,
            Components\Alert::class,
            Components\Avatar::class,
            Components\AvatarGroup::class,
            Components\Badge::class,
            Components\Banner::class,
            Components\BarChart::class,
            Components\Breadcrumbs::class,
            Components\Button::class,
            Components\Card::class,
            Components\Checkbox::class,
            Components\Container::class,
            Components\DateTimePicker::class,
            Components\Discreet::class,
            Components\Divider::class,
            Components\Dropdown::class,
            Components\DropdownItem::class,
            Components\EmptyState::class,
            Components\Grid::class,
            Components\Icon::class,
            Components\Input::class,
            Components\Link::class,
            Components\Modal::class,
            Components\NavSection::class,
            Components\NavItem::class,
            Components\PageHeader::class,
            Components\Pagination::class,
            Components\Progress::class,
            Components\Radio::class,
            Components\Select::class,
            Components\Skeleton::class,
            Components\SlideOver::class,
            Components\Sparkline::class,
            Components\Spinner::class,
            Components\Stat::class,
            Components\Stepper::class,
            Components\Table::class,
            Components\TabPanel::class,
            Components\Tabs::class,
            Components\Timeline::class,
            Components\TimelineItem::class,
            Components\Toast::class,
            Components\Textarea::class,
            Components\Toggle::class,
            Components\Tooltip::class,
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/frietzakje-ui.php',
            'frietzakje-ui'
        );
    }
}
