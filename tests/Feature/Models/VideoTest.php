<?php

use App\Models\Video;

it('gives back readable video duration', function () {
    $video = Video::factory()->create(['duration_in_min' => 10]);

    expect($video->getReadableDuration())->toEqual('10 min');
});
