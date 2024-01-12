<?php

namespace Console\Commands;

use Tests\TestCase;

class CreateTokenTest extends TestCase
{
    public function test_create_token_command_returns_a_token(): void
    {
        $this->artisan('app:create-token')
            ->assertSuccessful();
    }
}
