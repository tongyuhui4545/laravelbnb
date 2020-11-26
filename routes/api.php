<?php

use Illuminate\Http\Request;

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



Route::apiResource('bookables', 'Api\BookableController');
Route::get('bookables/{bookable}/availability', 'Api\BookableAvailabilityController')
->name('bookables.availability.show');
Route::get('bookables/{bookable}/reviews', 'Api\BookableReviewController')
->name('bookables.reviews.index');
Route::get('bookables/{bookable}/price', 'Api\BookablePriceController')
->name('bookables.price.show');


Route::apiResource('reviews', 'Api\ReviewController')->only(['show', 'store']);
Route::get('/booking-by-review/{reviewKey}', 'Api\BookingByReviewController')
     ->name('booking.by-review.show');

Route::post('checkout', 'Api\CheckoutController')->name('check');
