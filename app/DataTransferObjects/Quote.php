<?php

namespace App\DataTransferObjects;

readonly class Quote
{
    public function __construct(public string $quote)
    {
    }

    public function toString(): string
    {
        return $this->quote;
    }
}
