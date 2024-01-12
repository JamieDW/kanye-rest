<?php

namespace App\Facades;

use App\Quotable\QuoteManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string driver(string $driver = null)
 * @method static \App\DataTransferObjects\Quote quote()
 *
 * @see QuoteManager
 */
class Quote extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return QuoteManager::class;
    }
}
