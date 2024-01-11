<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $quotes = $this->quotes->get();

        return QuoteResource::collection($quotes);
    }

    /**
     * Display the resource.
     */
    public function refresh()
    {
        $this->quotes->purge();

        return response()->noContent();
    }
}
