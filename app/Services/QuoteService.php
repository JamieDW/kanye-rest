<?php

namespace App\Services;

use App\DataTransferObjects\Quote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class QuoteService
{
    private const string KEY = 'quotes';

    private string $url;

    public function __construct()
    {
        $this->url = config('services.kayne-rest.api');
    }

    /**
     * @return Quote[]
     */
    private function get(int $amount, array $cachedQuotes = []): array
    {
        $uniqueQuotes = [];

        while (count($uniqueQuotes) < $amount) {

            $response = Http::get($this->url);

            if ($response->failed()) {
                continue;
            }

            /** @var string|null $quote */
            $quote = $response->json('quote');

            if ($quote === null) {
                continue;
            }

            if (in_array($quote, $uniqueQuotes) || in_array($quote, $cachedQuotes)) {
                continue;
            }

            $uniqueQuotes[] = $quote;
        }

        return array_map(Quote::create(...), $uniqueQuotes);
    }

    public function random(int $amount): array
    {
        return Cache::rememberForever(self::KEY, fn () => $this->get($amount));
    }

    /**
     * @return Quote[]
     */
    public function new(int $amount): array
    {
        /** @var [] | null $cachedQuotes */
        $cachedQuotes = Cache::get(self::KEY, []);

        return $this->get($amount, $cachedQuotes);
    }

    public function purge(): bool
    {
        return Cache::forget(self::KEY);
    }
}
