<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;

it('it shows details for a given video', function () {
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    $video = $course->videos->first();

    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeText([
            $video->title,
            $video->description,
            $video->getReadableDuration(),
        ]);
});

it('it shows given video', function () {
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    $video = $course->videos->first();

    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"');
});
