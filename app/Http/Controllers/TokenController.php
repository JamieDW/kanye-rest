<?php

namespace App\Http\Controllers;

use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TokenController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $token = $request->bearerToken();

        if ($token === null || Cache::missing($token)) {
            $token = TokenService::create();
        }

        return response([
            'token' => $token,
        ]);
    }
}
