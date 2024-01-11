<?php

namespace Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TokenControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_token_endpoint_returns_a_successful_response(): void
    {
        $response = $this->get(route('token.generate'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
