# Frietzakje UI

A shared Blade component library and design system for the Frietzakje suite of applications. Built for Laravel with Tailwind CSS v4 and Alpine.js, it ships a dark-first palette, layouts, and a set of ready-to-use UI components so every app in the suite looks and behaves the same.

## Installation

```bash
composer require frietzakje/ui
```

The service provider is auto-registered via Laravel package discovery.

## Styling

The package's stylesheet defines the design tokens (`@theme`) and the custom classes the components rely on. Import it in your app's `resources/css/app.css`, after `@import 'tailwindcss';`, and add an `@source` so Tailwind scans the package views and generates the classes the components use:

```css
@import 'tailwindcss';
@import '../../vendor/frietzakje/ui/resources/css/frietzakje-ui.css';

@source '../../vendor/frietzakje/ui/resources/views';
```

Load the fonts (Nunito, Roboto, Roboto Slab, Montserrat) and Material Symbols in your layout, or use the provided `<x-frietzakje::layouts.app>` layout which already includes them.

## Usage

Components are registered under the `frietzakje` prefix:

```blade
<x-frietzakje-button variant="primary">Opslaan</x-frietzakje-button>
```

## Publishing

Publish the CSS assets, views, or config when you need to customise them:

```bash
php artisan vendor:publish --tag=frietzakje-ui-assets
php artisan vendor:publish --tag=frietzakje-ui-views
php artisan vendor:publish --tag=frietzakje-ui-config
```

## Documentation

The full component catalogue — every component, its props, and live examples — is documented in the consuming application (the Backoffice app exposes it at `/components`).

## Requirements

- PHP 8.3+
- Laravel 13+
- Tailwind CSS 4+
- Alpine.js

## License

MIT
