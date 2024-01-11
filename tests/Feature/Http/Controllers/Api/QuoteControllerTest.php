<?php

namespace Tests\Feature\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    public function test_quotes_index_returns_a_successful_response_when_authenticated(): void
    {
        $response = $this->get(route('quotes.index'), $this->getAuthenticatedHeader());

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_quotes_new_returns_a_successful_response_when_authenticated(): void
    {
        $response = $this->get(route('quotes.new'), $this->getAuthenticatedHeader());

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_quotes_purge_returns_a_no_content_response_when_authenticated(): void
    {
        $response = $this->get(route('quotes.purge'), $this->getAuthenticatedHeader());

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_quotes_index_returns_a_unsuccessful_response_when_unauthenticated(): void
    {
        $response = $this->get(route('quotes.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_quotes_new_returns_a_unsuccessful_response_when_unauthenticated(): void
    {
        $response = $this->get(route('quotes.new'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_quotes_purge_returns_a_unsuccessful_response_when_unauthenticated(): void
    {
        $response = $this->get(route('quotes.purge'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function getAuthenticatedHeader(): array
    {

        $token = $this->get(route('token.generate'))['token'];

        return [
            'Authorization' => 'Bearer '.$token,
        ];
    }
}
