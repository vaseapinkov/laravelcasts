<?php

use App\Models\Course;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

it('it shows courses overview', function () {
    // Arrange
    $firstCourse = Course::factory()->relased()->create();
    $secondCourse = Course::factory()->relased()->create();
    $thirdCourse = Course::factory()->relased()->create();

    // Act & Assert
    get(route('pages.home'))->assertSeeText([
        $firstCourse->title,
        $firstCourse->description,
        $secondCourse->title,
        $secondCourse->description,
        $thirdCourse->title,
        $thirdCourse->description,
    ]);
});

it('shows only released courses', function () {
    // Arrange
    $releasedCourse = Course::factory()->relased()->create();
    $notReleasedCourse = Course::factory()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertSeeText($releasedCourse->title)
        ->assertDontSeeText($notReleasedCourse->title);
});

it('it shows courses by release date', function () {
    // Arrange
    $releasedCourse = Course::factory()->relased(Carbon::yesterday())->create();
    $newestReleasedCourse = Course::factory()->relased()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertSeeTextInOrder([
            $newestReleasedCourse->title,
            $releasedCourse->title,
        ]);
});

it('includes login if not logged in', function () {
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Log In')
        ->assertSee(route('login'));
});

it('includes logout if logged in', function () {
    loginAsUser();

    get(route('pages.home'))
        ->assertOk()
        ->assertSee('Log Out')
        ->assertSee(route('logout'));
});

it('includes courses links', function () {
    $firstCourse = Course::factory()->relased()->create();
    $secondCourse = Course::factory()->relased()->create();
    $thirdCourse = Course::factory()->relased()->create();

    get(route('pages.home'))
        ->assertOk()
        ->assertSee([
            route('pages.course-details', $firstCourse),
            route('pages.course-details', $secondCourse),
            route('pages.course-details', $thirdCourse),
        ]);
});
