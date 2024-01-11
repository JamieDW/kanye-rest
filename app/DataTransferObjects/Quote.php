<?php

namespace App\DataTransferObjects;

readonly class Quote
{
    public function __construct(public string $quote)
    {
    }

    public static function create(string $quote): self
    {
        return new self($quote);
    }
}
