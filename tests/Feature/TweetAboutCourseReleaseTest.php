<?php

use App\Console\Commands\TweetAboutCourseReleaseCommand;
use App\Models\Course;

it('tweets about release for provided course', function () {
    Twitter::fake();
    $course = Course::factory()->create();

    $this->artisan(TweetAboutCourseReleaseCommand::class, ['courseId' => $course->id]);

    Twitter::assertTweetSent("I just released $course->title Check it out on ".route('pages.course-details', $course));
});
