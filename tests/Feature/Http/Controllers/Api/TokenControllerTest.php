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

    public function test_token_endpoint_returns_a_token(): void
    {
        $response = $this->get(route('token.generate'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['token']);
    }

    public function test_token_endpoint_returns_the_same_token_if_authenticated(): void
    {
        $originalToken = $this->get(route('token.generate'))['token'];

        $response = $this->get(route('token.generate'), [
            'Authorization' => 'Bearer ' . $originalToken
        ]);

        $this->assertEquals($originalToken, $response['token']);
    }
}
