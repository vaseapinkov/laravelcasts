<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('gives bac successful response from home page', function () {
    // Act && Assert
    get(route('home'))
        ->assertOk();
});
