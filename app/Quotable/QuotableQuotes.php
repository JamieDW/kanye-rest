<?php

namespace App\Quotable;

use App\Contracts\Quotable;
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
    public function quote(): ?string
    {
        $response = Http::get($this->url);

        if ($response->failed()) {
            return null;
        }

        return $response->json('content');
    }
}
