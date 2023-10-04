<?php

use App\Models\Course;
use App\Models\User;

use function Pest\Laravel\get;

it('gives back successful response from home page', function () {
    // Act && Assert
    get(route('pages.home'))
        ->assertOk();
});

it('gives back successful response from details page', function () {
    // Arrange
    $course = Course::factory()->relased()->create();

    // Act && Assert
    get(route('pages.course-details', $course))
        ->assertOk();
});

it('gives back successful response for dashboard page', function () {
    // Act && Assert
    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk();
});
