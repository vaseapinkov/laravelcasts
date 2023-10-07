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

it('show course video count', function () {
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

it('includes paddle checkout button', function () {
    config()->set('services.paddle.vendor-id', 'vendor-id');

    $course = Course::factory()
        ->relased()
        ->create(['paddle_product_id' => 'product-id']);

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSee('<script src="https://cdn.paddle.com/paddle/paddle.js"></script>', false)
        ->assertSee('Paddle.Setup({ vendor: vendor-id });', false)
        ->assertSee('<a href="#!" class="paddle_button" data-product="product-id">Buy Now!</a>', false);
});
