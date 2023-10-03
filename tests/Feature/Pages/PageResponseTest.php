<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

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
