<?php

namespace Tests\Unit\Facades;

use App\Facades\Quote;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    public function test_quote_facade_returns_a_quote_on_the_kayne_driver(): void
    {
        $quote = Quote::driver('kayne')->quote();

        $this->assertIsString($quote);
    }

    public function test_quote_facade_returns_a_quote_on_the_quotable_driver(): void
    {
        $quote = Quote::driver('quotable')->quote();

        $this->assertIsString($quote);
    }

    public function test_quote_facade_throws_an_invalid_argument_exception_when_an_unsupported_driver_is_present(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Quote::driver('unsupported_driver_bla_123')->quote();
    }

    public function test_quote_facade_returns_null_on_incorrect_data(): void
    {
        Http::fake([
            config('services.kayne-rest.api') => Http::response(['foo' => 'bar'], Response::HTTP_OK),
            config('services.quotable.api.api') => Http::response(['foo' => 'bar'], Response::HTTP_OK),
        ]);

        $kayneQuote = Quote::driver('kayne')->quote();
        $quotableQuote = Quote::driver('quotable')->quote();

        $this->assertNull($kayneQuote);
        $this->assertNull($quotableQuote);
    }

    public function test_quote_facade_returns_null_on_failed_response(): void
    {
        Http::fake([
            config('services.kayne-rest.api') => Http::response(status: Response::HTTP_SERVICE_UNAVAILABLE),
            config('services.quotable.api.api') => Http::response(status: Response::HTTP_SERVICE_UNAVAILABLE),
        ]);

        $kayneQuote = Quote::driver('kayne')->quote();
        $quotableQuote = Quote::driver('quotable')->quote();

        $this->assertNull($kayneQuote);
        $this->assertNull($quotableQuote);
    }
}
