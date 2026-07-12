# Frietzakje UI

A shared component library for the Frietzakje ecosystem. Built with Laravel, Blade, Tailwind CSS v4, and Alpine.js.

## Components

- **Button** - Versatile button with variants (primary, secondary, ghost, success, danger, danger-solid) and sizes
- **Card** - Container with glass morphism effect, hoverable and padded options
- **Input** - Form input with label, help text, and error states
- **Badge** - Status indicators with multiple variants
- **Modal** - Alpine.js powered modal with transitions
- **Icon** - Material Symbols icon wrapper
- **Empty State** - Placeholder for empty data states
- **Discreet** - Privacy wrapper for sensitive information

## Installation

```bash
composer require frietzakje/ui
```

The package will auto-register via Laravel's package discovery.

## Usage

All components are available under the `frietzakje::` namespace:

```blade
<x-frietzakje::button variant="primary" size="md">
    Click me
</x-frietzakje::button>

<x-frietzakje::card :hoverable="true" :padded="true">
    <h3>Card Title</h3>
    <p>Card content here</p>
</x-frietzakje::card>

<x-frietzakje::input
    name="email"
    label="Email Address"
    help="We'll never share your email"
/>

<x-frietzakje::badge variant="success">Active</x-frietzakje::badge>
```

## Publishing Assets

Publish CSS assets (optional):

```bash
php artisan vendor:publish --tag=frietzakje-ui-assets
```

Publish views for customization (optional):

```bash
php artisan vendor:publish --tag=frietzakje-ui-views
```

Publish configuration (optional):

```bash
php artisan vendor:publish --tag=frietzakje-ui-config
```

## Design System

The library uses a dark-first design system with:

- **Primary**: #fedb00 (Frietzakje yellow)
- **Success**: #2ac427
- **Danger**: #cb0202
- **Message**: #02a4c8

Fonts:
- Display: Montserrat
- Body: Roboto
- Sans: Nunito

## Requirements

- PHP 8.3+
- Laravel 13.0+
- Tailwind CSS 4.0+
- Alpine.js (for Modal component)

## License

MIT
