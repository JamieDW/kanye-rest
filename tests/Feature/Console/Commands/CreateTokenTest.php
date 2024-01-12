<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\CreateToken;
use Tests\TestCase;

class CreateTokenTest extends TestCase
{
    public function test_create_token_command_returns_a_token(): void
    {
        $this->artisan(CreateToken::class)
            ->assertSuccessful();
    }
}
