<?php

use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('token', TokenController::class);

Route::controller(QuoteController::class)
    ->middleware('auth.bearer')
    ->prefix('quotes')
    ->name('quotes.')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('new', 'new')->name('new');
        Route::get('purge', 'purge')->name('purge');
    });




