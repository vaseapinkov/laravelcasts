<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\get;

it('can not be accessed by a guest', function () {
    $course = Course::factory()->create();

    get(route('pages.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes a video player', function () {
    $course = Course::factory()->create();

    loginAsUser();
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});

it('shows first course video by default', function () {
    $course = Course::factory()
        ->has(Video::factory()->state(['title' => 'My Video']))
        ->create();

    loginAsUser();
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeText('My Video');
});

it('shows provided course video', function () {
    $course = Course::factory()
        ->has(
            Video::factory()
                ->state(new Sequence(['title' => 'First Video'], ['title' => 'Second Video']))
                ->count(2)
        )
        ->create();

    loginAsUser();
    get(route('pages.course-videos', [
        'course' => $course,
        'video' => $course->videos()->orderByDesc('id')->first(),
    ]))
        ->assertOk()
        ->assertSeeText('Second Video');
});
