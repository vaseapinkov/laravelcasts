<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('con not be accessed by a guest', function () {
    // Act and Assert
    get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('list purchased courses', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory()->count(2)->state(
            new Sequence(
                ['title' => 'Course A'],
                ['title' => 'Course B'],
            )
        ))
        ->create();

    // Act and Assert
    $this->actingAs($user);
    get(route('dashboard'))
        ->assertOk()
        ->assertSeeText([
            'Course A',
            'Course B',
        ]);
});

it('doe not see other courses', function () {
    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()->create();

    // Act & Assert
    $this->actingAs($user);
    get(route('dashboard'))
        ->assertOk()
        ->assertDontSeeText($course->title);
});

it('show last purchased courses first', function () {
    // Arrange
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->courses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]);
    $user->courses()->attach($lastPurchasedCourse, ['created_at' => Carbon::now()]);

    // Act & Assert
    $this->actingAs($user);
    get(route('dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            $lastPurchasedCourse->title,
            $firstPurchasedCourse->title,
        ]);
});

it('includes link to product video', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory())
        ->create();

    $this->actingAs($user);
    get(route('dashboard'))
        ->assertOk()
        ->assertSeeText('Watch Video')
        ->assertSee(route('pages.course-videos', Course::first()));
});
