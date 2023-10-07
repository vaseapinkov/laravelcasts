<?php

use App\Services\Twitter\NullTwitterClient;

it('return empty array for a tweet call', function () {
    expect(new NullTwitterClient())->tweet('Tweet')->toBeArray()->toBeEmpty();
});
