<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TokenService
{
    public static function create(): string
    {
        $token = Str::random(24);

        Cache::put($token, $token, now()->addHour());

        return $token;
    }
}
