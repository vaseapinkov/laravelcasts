<?php

use App\Models\Course;
use App\Models\Video;

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

it('doe not find jetstream registration page', function () {
    get('register')->assertNotFound();
});

it('gives successful response for a videos page', function () {
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    loginAsUser();
    get(route('pages.course-videos', $course))->assertOk();
});
