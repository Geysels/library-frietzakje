<?php

use Frietzakje\Ui\Components\Badge;
use Frietzakje\Ui\Components\Banner;
use Frietzakje\Ui\Components\Button;
use Frietzakje\Ui\Components\Card;
use Frietzakje\Ui\Components\Container;
use Frietzakje\Ui\Components\Grid;
use Frietzakje\Ui\Components\Input;
use Frietzakje\Ui\Components\Toast;
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

test('banner component renders correctly', function () {
    $component = new Banner();
    $view = $component->render();

    expect($view->name())->toBe('frietzakje::components.banner');
});

test('banner renders with different variants', function () {
    $variants = ['primary', 'success', 'danger', 'message', 'neutral'];

    foreach ($variants as $variant) {
        $html = Blade::render("<x-frietzakje::banner variant=\"{$variant}\">Notice</x-frietzakje::banner>");
        expect($html)->toContain('Notice');
    }
});

test('banner renders dismissible button', function () {
    $html = Blade::render('<x-frietzakje::banner :dismissible="true">Dismissible</x-frietzakje::banner>');

    expect($html)
        ->toContain('Dismissible')
        ->toContain('@click="show = false"');
});

test('container component renders correctly', function () {
    $component = new Container();
    $view = $component->render();

    expect($view->name())->toBe('frietzakje::components.container');
});

test('container renders with different sizes', function () {
    $sizes = ['sm', 'default', 'lg', 'xl', 'full'];

    foreach ($sizes as $size) {
        $html = Blade::render("<x-frietzakje::container size=\"{$size}\">Content</x-frietzakje::container>");
        expect($html)->toContain('Content');
    }
});

test('grid component renders correctly', function () {
    $component = new Grid();
    $view = $component->render();

    expect($view->name())->toBe('frietzakje::components.grid');
});

test('grid renders with column configuration', function () {
    $html = Blade::render('<x-frietzakje::grid cols="3" gap="4"><div>Item</div></x-frietzakje::grid>');

    expect($html)
        ->toContain('Item')
        ->toContain('grid');
});

test('toast component renders correctly', function () {
    $component = new Toast();
    $view = $component->render();

    expect($view->name())->toBe('frietzakje::components.toast');
});

test('toast renders with position classes', function () {
    $positions = ['top-right', 'top-left', 'bottom-right', 'bottom-left'];

    foreach ($positions as $position) {
        $html = Blade::render("<x-frietzakje::toast position=\"{$position}\" />");
        expect($html)->toContain('fixed');
    }
});
