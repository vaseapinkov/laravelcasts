<?php

namespace App\Services\Twitter;

use Illuminate\Support\Facades\Facade;
use Tests\Fakes\TwitterFake;

class TweeterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TwitterClientInterface::class;
    }

    public static function fake()
    {
        self::swap(new TwitterFake);
    }
}
