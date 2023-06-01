<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DealController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DealController::class, 'showDealForm']);
Route::get('/deal', [DealController::class, 'showDealForm']);
Route::post('/submit-deal', [DealController::class, 'createDeal']);

Route::get('/account', [AccountController::class, 'showAccountForm']);
Route::post('/submit-account', [AccountController::class, 'createAccount']);
