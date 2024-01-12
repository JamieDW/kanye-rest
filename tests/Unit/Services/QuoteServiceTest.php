<?php

namespace Tests\Unit\Services;

use App\DataTransferObjects\Quote;
use App\Services\QuoteService;
use Tests\TestCase;

class QuoteServiceTest extends TestCase
{
    private QuoteService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(QuoteService::class);
    }

    public function test_quotes_are_returned_as_a_dto_array(): void
    {
        $quotes = $this->service->random(5);

        $this->assertContainsOnlyInstancesOf(Quote::class, $quotes);
        $this->assertObjectHasProperty('quote', $quotes[0]);
    }

    public function test_quotes_expect_the_correct_count(): void
    {
        $expectedCount = 5;

        $quotes = $this->service->random($expectedCount);

        $this->assertCount($expectedCount, $quotes);
    }

    public function test_quotes_expect_the_incorrect_count(): void
    {
        $quotes = $this->service->random(5);

        $this->assertNotCount(10, $quotes);
    }

    public function test_quotes_are_truly_unique_to_previous_quotes(): void
    {
        $expectedCount = 5;

        $initialRandomQuotes = $this->service->random($expectedCount);

        $newQuotes = $this->service->new($expectedCount);

        // Transform dto's to simple string array, ready for asserting

        $initialRandomQuotes = array_map(fn (Quote $quote) => $quote->toString(), $initialRandomQuotes);
        $newQuotes = array_map(fn (Quote $quote) => $quote->toString(), $newQuotes);

        $this->assertCount(
            $expectedCount,
            array_diff($initialRandomQuotes, $newQuotes)
        );
    }

    public function test_quotes_are_the_same_to_previous_quotes(): void
    {
        $expectedCount = 5;

        $initialRandomQuotes = $this->service->random($expectedCount);

        $newQuotes = $this->service->random($expectedCount);

        // Transform dto's to simple string array, ready for asserting

        $initialRandomQuotes = array_map(fn (Quote $quote) => $quote->toString(), $initialRandomQuotes);
        $newQuotes = array_map(fn (Quote $quote) => $quote->toString(), $newQuotes);

        $this->assertCount(
            $expectedCount,
            array_intersect($initialRandomQuotes, $newQuotes)
        );
    }
}
