<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Services\QuoteService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected QuoteService $quotes,
    ) {
    }

    /**
     * Store the newly created resource in storage.
     */
    public function index(Request $request)
    {
        $quotes = $this->quotes->random(5);

        return QuoteResource::collection($quotes);
    }

    public function new(Request $request)
    {
        $quotes = $this->quotes->new(5);

        return QuoteResource::collection($quotes);
    }

    /**
     * Display the resource.
     */
    public function purge()
    {
        $this->quotes->purge();

        return response()->noContent();
    }
}
