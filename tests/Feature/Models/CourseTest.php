<?php

use App\Models\Course;
use App\Models\Video;

test('only returns released courses for released scope', function () {
    // Arrange

    Course::factory()->relased()->create();
    Course::factory()->create();

    // Act & Assert
    expect(Course::released()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);

});

it('has video', function () {
    // Arrange
    $course = Course::factory()->create();
    Video::factory()->count(3)->create(['course_id' => $course->id]);
    // Act & Assert
    expect($course->videos)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Video::class);
});
