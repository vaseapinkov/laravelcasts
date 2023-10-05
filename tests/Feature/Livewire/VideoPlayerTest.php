<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

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

it('shows list of all course videos', function () {
    $course = Course::factory()
        ->has(Video::factory()
            ->count(3)
            ->state(new Sequence(
                ['title' => 'First Video'],
                ['title' => 'Second Video'],
                ['title' => 'Third Video'],
            )))
        ->create();

    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSeeText([
            'First Video',
            'Second Video',
            'Third Video',
        ])->assertSeeHtml([
            route('pages.course-videos', Video::where('title', 'First Video')->first()),
            route('pages.course-videos', Video::where('title', 'Second Video')->first()),
            route('pages.course-videos', Video::where('title', 'Third Video')->first()),
        ]);
});
