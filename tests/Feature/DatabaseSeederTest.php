<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;

it('adds given courses', function () {
    $this->assertDatabaseEmpty(Course::class);

    $this->artisan('db:seed');

    $this->assertDatabaseCount(Course::class, 3);
    $this->assertDatabaseHas(Course::class, ['title' => 'Laravel For Beginners']);
    $this->assertDatabaseHas(Course::class, ['title' => 'Advanced Laravel']);
    $this->assertDatabaseHas(Course::class, ['title' => 'TDD The Laravel Way']);
});

it('adds given courses only once', function () {
    $this->assertDatabaseEmpty(Course::class);

    $this->artisan('db:seed');
    $this->artisan('db:seed');

    $this->assertDatabaseCount(Course::class, 3);
});

it('adds given videos', function () {
    $this->assertDatabaseEmpty(Video::class);

    $this->artisan('db:seed');

    $laravelForBeginnersCourse = Course::where('title', 'Laravel For Beginners')->first();
    $advancedLaravelCourse = Course::where('title', 'Advanced Laravel')->first();
    $tddTheLaravelWayCourse = Course::where('title', 'TDD The Laravel Way')->first();
    $this->assertDatabaseCount(Video::class, 8);

    expect($laravelForBeginnersCourse)->videos->toHaveCount(3)
        ->and($advancedLaravelCourse)->videos->toHaveCount(3)
        ->and($tddTheLaravelWayCourse)->videos->toHaveCount(2);

});

it('adds given videos only once', function () {
    $this->assertDatabaseEmpty(Video::class);

    $this->artisan('db:seed');
    $this->artisan('db:seed');

    $this->assertDatabaseCount(Video::class, 8);
});

it('adds local test user', function () {
    App::partialMock()->shouldReceive('environment')->andReturn('local');

    $this->assertDatabaseCount(User::class, 0);

    $this->artisan('db:seed');

    $this->assertDatabaseCount(User::class, 1);
});

it('does not add test user for production', function () {
    App::partialMock()->shouldReceive('environment')->andReturn('production');

    $this->assertDatabaseCount(User::class, 0);

    $this->artisan('db:seed');
    $this->artisan('db:seed');

    $this->assertDatabaseCount(User::class, 0);
});
