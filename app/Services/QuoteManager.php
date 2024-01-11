<?php

namespace App\Services;

use App\Contracts\Quotable;
use App\Quoting\KayneQuotes;
use App\Quoting\QuotableQuotes;
use Illuminate\Support\Manager;
use Override;

class QuoteManager extends Manager implements Quotable
{
    public function createKayneDriver(): Quotable
    {
        return new KayneQuotes();
    }

    public function createQuotableDriver(): Quotable
    {
        return new QuotableQuotes();
    }

    #[Override]
    public function quotes(int $amount)
    {
        return $this->driver()->quotes($amount);
    }

    #[Override]
    public function getDefaultDriver()
    {
        return $this->config->get('quote.default', 'kayne');
    }
}
