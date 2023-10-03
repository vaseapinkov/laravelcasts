<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('it shows courses overview', function () {
    // Arrange
    $firstCourse = Course::factory()->relased()->create();
    $secondCourse = Course::factory()->relased()->create();
    $thirdCourse = Course::factory()->relased()->create();

    // Act & Assert
    get(route('home'))->assertSeeText([
        $firstCourse->title,
        $firstCourse->description,
        $secondCourse->title,
        $secondCourse->description,
        $thirdCourse->title,
        $thirdCourse->description,
    ]);
});

test('shows only released courses', function () {
    // Arrange
    $releasedCourse = Course::factory()->relased()->create();
    $notReleasedCourse = Course::factory()->create();

    // Act & Assert
    get(route('home'))
        ->assertSeeText($releasedCourse->title)
        ->assertDontSeeText($notReleasedCourse->title);
});

test('it shows courses by release date', function () {
    // Arrange
    $releasedCourse = Course::factory()->relased(Carbon::yesterday())->create();
    $newestReleasedCourse = Course::factory()->relased()->create();

    // Act & Assert
    get(route('home'))
        ->assertSeeTextInOrder([
            $newestReleasedCourse->title,
            $releasedCourse->title,
        ]);
});
