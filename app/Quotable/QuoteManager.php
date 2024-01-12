<?php

namespace App\Quotable;

use App\Contracts\Quotable;
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
    public function quote(): ?string
    {
        return $this->driver()->quote();
    }

    #[Override]
    public function getDefaultDriver()
    {
        return $this->config->get('quote.default', 'kayne');
    }
}
