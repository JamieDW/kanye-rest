<?php

namespace App\Quotable;

use App\Contracts\Quotable;
use Illuminate\Support\Facades\Http;
use Override;

class KayneQuotes implements Quotable
{
    private string $url;

    public function __construct()
    {
        $this->url = config('services.kayne-rest.api');
    }

    #[Override]
    public function quote(): ?string
    {
        $response = Http::get($this->url);

        if ($response->failed()) {
            return null;
        }

        return $response->json('quote');
    }
}
