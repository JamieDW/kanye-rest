<?php

namespace App\Quoting;

use App\Contracts\Quotable;
use App\DataTransferObjects\Quote;
use Illuminate\Support\Facades\Http;
use Override;

class QuotableQuotes implements Quotable
{
    private string $url;

    public function __construct()
    {
        $this->url = config('services.quotable.api');
    }

    #[Override]
    public function quotes(int $amount): array
    {
        $uniqueQuotes = [];

        while (count($uniqueQuotes) < $amount) {

            $response = Http::get($this->url);

            if ($response->failed()) {
                continue;
            }

            /** @var string|null $quote */
            $quote = $response->json('content');

            if ($quote === null) {
                continue;
            }

            //            || in_array($quote, $cachedQuotes)
            if (in_array($quote, $uniqueQuotes)) {
                continue;
            }

            $uniqueQuotes[] = $quote;
        }

        return array_map(Quote::create(...), $uniqueQuotes);
    }
}
