<?php

use Frietzakje\Ui\Components\Button;
use Frietzakje\Ui\Components\Card;
use Frietzakje\Ui\Components\Badge;
use Frietzakje\Ui\Components\Input;
use Illuminate\Support\Facades\Blade;

test('button component renders correctly', function () {
    $component = new Button();
    $view = $component->render();

    expect($view->name())->toBe('frietzakje::components.button');
});

test('button renders with different variants', function () {
    $html = Blade::render('<x-frietzakje::button variant="primary">Click me</x-frietzakje::button>');

    expect($html)
        ->toContain('Click me')
        ->toContain('bg-primary');
});

test('card component renders correctly', function () {
    $component = new Card();
    $view = $component->render();

    expect($view->name())->toBe('frietzakje::components.card');
});

test('card renders with hoverable state', function () {
    $html = Blade::render('<x-frietzakje::card :hoverable="true">Content</x-frietzakje::card>');

    expect($html)
        ->toContain('Content')
        ->toContain('hover:border-primary');
});

test('badge component renders with variants', function () {
    $variants = ['neutral', 'primary', 'success', 'danger', 'info'];

    foreach ($variants as $variant) {
        $html = Blade::render("<x-frietzakje::badge variant=\"{$variant}\">Label</x-frietzakje::badge>");
        expect($html)->toContain('Label');
    }
});

test('input component renders with label and help text', function () {
    $html = Blade::render('<x-frietzakje::input name="email" label="Email" help="Enter your email" />');

    expect($html)
        ->toContain('Email')
        ->toContain('Enter your email')
        ->toContain('name="email"');
});

test('input component shows error state', function () {
    $html = Blade::render('<x-frietzakje::input name="password" error="Password is required" />');

    expect($html)
        ->toContain('Password is required')
        ->toContain('border-danger');
});

test('input component hardens password fields', function () {
    $html = Blade::render('<x-frietzakje::input type="password" name="password" />');

    expect($html)
        ->toContain('autocapitalize="none"')
        ->toContain('autocorrect="off"')
        ->toContain('spellcheck="false"');
});
