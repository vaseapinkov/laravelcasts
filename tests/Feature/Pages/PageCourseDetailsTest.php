<?php

use App\Models\Course;
use App\Models\Video;

use function Pest\Laravel\get;

it('doe not find unreleased course', function () {
    // Arrange
    $course = Course::factory()->create();

    get(route('pages.course-details', $course))
        ->assertNotFound();

});

it('show course details', function () {
    // Arrange
    $course = Course::factory()->relased()->create();

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            $course->tagline,
            ...$course->learnings,
        ])
        ->assertSee(asset("images/$course->image_name"));

});

test('show course video count', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()->count(3))
        ->relased()
        ->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 Videos');
});
