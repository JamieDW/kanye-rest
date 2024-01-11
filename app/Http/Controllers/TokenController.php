<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $token = $request->bearerToken();

        if($token === null || Cache::missing($token)) {
            $token = Str::random(24);
            Cache::put($token, $token, now()->addHour());
        }

        return response([
            'token' => $token
        ]);
    }
}
