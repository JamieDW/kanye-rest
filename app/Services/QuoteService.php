<?php

namespace App\Services;

use App\DataTransferObjects\Quote;
use App\Quotable\QuoteManager;
use Illuminate\Support\Facades\Cache;

class QuoteService
{
    private const string KEY = 'quotes';

    public function __construct(public QuoteManager $manager)
    {
    }

    /**
     * @return string[]
     */
    private function get(int $amount, array $cachedQuotes = []): array
    {
        $uniqueQuotes = [];

        while (count($uniqueQuotes) < $amount) {

            $quote = $this->manager->quote();

            if ($quote === null) {
                continue;
            }

            if (in_array($quote, $uniqueQuotes) || in_array($quote, $cachedQuotes)) {
                continue;
            }

            $uniqueQuotes[] = $quote;
        }

        return $uniqueQuotes;
    }

    /**
     * @return Quote[]
     */
    public function random(int $amount): array
    {
        /** @var string[] $cachedQuotes */
        $cachedQuotes = Cache::rememberForever(self::KEY, fn () => $this->get($amount));

        return $this->transform($cachedQuotes);
    }

    /**
     * @return Quote[]
     */
    public function new(int $amount): array
    {
        /** @var string[] $cachedQuotes */
        $cachedQuotes = Cache::get(self::KEY, []);

        $quotes = $this->get($amount, $cachedQuotes);

        return $this->transform($quotes);
    }

    public function purge(): bool
    {
        return Cache::forget(self::KEY);
    }

    /**
     * @return Quote[]
     */
    private function transform(array $quotes): array
    {
        return array_map(
            fn (string $quote) => (new Quote($quote)),
            $quotes);
    }
}
