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
            Components\Button::class,
            Components\Card::class,
            Components\Input::class,
            Components\Badge::class,
            Components\Modal::class,
            Components\Icon::class,
            Components\EmptyState::class,
            Components\Discreet::class,
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
