<?php

use Orchestra\Testbench\TestCase;
use Frietzakje\Ui\UiServiceProvider;

uses(TestCase::class)->in('Feature');

// Set up the test environment
uses()->beforeEach(function () {
    $this->app->register(UiServiceProvider::class);
})->in('Feature');

function getPackageProviders($app)
{
    return [UiServiceProvider::class];
}
