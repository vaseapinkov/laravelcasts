<?php

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Services\Twitter\TwitterClient;

it('calls oauth class', function () {
    $mock = mock(TwitterOAuth::class)
        ->shouldReceive('post')
        ->withArgs(['statuses/update', ['status' => 'My tweet message']])
        ->andReturn(['status' => 'My tweet message'])
        ->getMock();

    $twitterClient = (new TwitterClient($mock));

    expect($twitterClient->tweet('My tweet message'))->toEqual(['status' => 'My tweet message']);
});
