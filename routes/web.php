<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingCalculatorController;
use App\Http\Controllers\GoogleReviewController;

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
Route::view('/', 'reviews.rating_calculator')->name('rating-calculator.index');
//Route::get('/calculate-rating', 'RatingCalculatorController@getReviews')->name('rating-calculator.calculate');
//Route::get('/reviews', [RatingCalculatorController::class, 'getReviews'])->name('rating-calculator.calculate');

Route::post('/google-reviews', [GoogleReviewController::class, 'getReviews'])->name('rating-calculator.calculate');

Route::get('/autocomplete', [GoogleReviewController::class, 'autocomplete']);


Route::view('/irfan', 'reviews.irfan');