<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;

it('it shows details for a given video', function () {
    $course = Course::factory()
        ->has(Video::factory()->state([
            'title' => 'Video Title',
            'description' => 'Video Description',
            'duration' => 10,
        ]))->create();

    Livewire::test(VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSeeText([
            'Video Title',
            'Video Description',
            '10 min',
        ]);
});

it('it shows given video', function () {
    $course = Course::factory()
        ->has(Video::factory()->state([
            'vimeo_id' => 'vimeo-id',
        ]))->create();

    Livewire::test(VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSee('<iframe src="https://player.vimeo.com/video/vimeo-id"', false);
});
