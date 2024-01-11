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
    public function get(int $amount = 5): array
    {
        // TODO
    }

    public function random()
    {
    }

    public function purge(): bool
    {
        return Cache::forget(self::KEY);
    }
}
