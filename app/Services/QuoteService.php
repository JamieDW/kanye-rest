<?php

namespace App\Services;

use App\DataTransferObjects\Quote;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
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
    private function get(int $amount): array
    {
        $uniqueQuotes = [];

        while (count($uniqueQuotes) < $amount) {

            $response = Http::get($this->url);

            if($response->failed()) {
                continue;
            }

            /** @var string|null $quote */
            $quote = $response->json('quote');

            if($quote === null) {
                continue;
            }

            if(in_array($quote, $uniqueQuotes)) {
                continue;
            }

            $uniqueQuotes[] = $quote;
        }

        return array_map(Quote::create(...), $uniqueQuotes);
    }

    public function random(int $amount)
    {
        return Cache::rememberForever(self::KEY, fn() => $this->get($amount));
    }

    public function purge(): bool
    {
        return Cache::forget(self::KEY);
    }
}
