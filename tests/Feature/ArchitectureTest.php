<?php

it('finds debug statements', function () {
    expect(['dd', 'dump', 'ray'])
        ->not->toBeUsed();
});

it('does not use validator facade', function () {
    expect(\Illuminate\Support\Facades\Validator::class)
        ->not->toBeUsed()
        ->ignoring('App\Actions\Fortify');
});
