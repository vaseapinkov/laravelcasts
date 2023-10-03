<?php

use function Pest\Laravel\get;

it('gives bac successful response from home page', function () {
    // Act && Assert
    get(route('home'))
        ->assertOk();
});
