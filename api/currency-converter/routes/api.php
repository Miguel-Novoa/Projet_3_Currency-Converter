<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PairController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AdminController::class, 'login']);
Route::post('/register', [AdminController::class, 'store']);

Route::post('/currencies/add', [CurrencyController::class, 'add']);
Route::get('/currencies/get', [CurrencyController::class, 'getAllCurrencies']);
Route::delete('/currencies/delete/{currency}', [CurrencyController::class, 'deleteCurrency']);
Route::get('/currencies/get/{currency}', [CurrencyController::class, 'getOneCurrency']);

Route::post('/pairs/add', [PairController::class, 'add']);
Route::get('/pairs/get', [PairController::class, 'getAllPairs']);
Route::delete('/pairs/delete/{pair}', [PairController::class, 'destroy']);
Route::put('/pairs/update/{pair}', [PairController::class, 'updatePair']);
