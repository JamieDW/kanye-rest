<?php

namespace Tests\Unit\Services;

use App\Services\TokenService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TokenServiceTest extends TestCase
{
    public function test_token_is_of_expected_type_string(): void
    {
        $token = TokenService::create();

        $this->assertIsString($token);
    }

    public function test_token_is_cached_temporally(): void
    {
        $spy = Cache::spy();

        $token = TokenService::create();

        $spy->shouldHaveReceived('put')
            ->once()
            ->with($token, $token, 10 * 60);
    }

    public function test_token_is_purged_after_ttl(): void
    {
        $token = TokenService::create();

        Carbon::setTestNow(now()->addMinutes(10));

        $this->assertTrue(Cache::missing($token));
    }

    public function test_token_is_not_purged_before_ttl(): void
    {
        $token = TokenService::create();

        Carbon::setTestNow(now()->addMinutes(9));

        $this->assertTrue(Cache::has($token));
    }
}
