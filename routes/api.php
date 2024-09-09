<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'Api\LoginController@login');
Route::post('/signup', 'Api\LoginController@signup');
Route::post('/socialLogin', 'Api\LoginController@socialLogin');
Route::post('/forgot-password', 'Api\LoginController@forgotPassword');
Route::post('/user/logout', 'Api\LoginController@logout')->middleware('auth:api');

Route::post('/general', 'Api\SettingsController@general');
Route::post('/faq', 'Api\SettingsController@faq');
Route::post('/cms', 'Api\SettingsController@cms');
Route::post('/category', 'Api\CategoryController@category');
Route::get('/get-sub-category','Api\CategoryController@subCategory');

Route::middleware('auth:api')->get('/get-profile', 'Api\LoginController@getProfile');
Route::middleware('auth:api')->post('/update-profile', 'Api\LoginController@updateProfile');
Route::middleware('auth:api')->post('/change-password', 'Api\LoginController@changePassword');
Route::middleware('auth:api')->post('/update-notification-token', 'Api\LoginController@updateNotificationToken');

Route::post('vendor/customer-reviews/get', 'Api\VendorController@getVendorReviews');

//For Vendor Routes
Route::middleware('auth:api')->group(function () {

    Route::post('event/create', 'Api\EventController@create');
    Route::post('event/get', 'Api\EventController@get');
    Route::post('event/detail', 'Api\EventController@detail');
    Route::post('event/delete', 'Api\EventController@delete');

    Route::post('vendor/get', 'Api\VendorController@get');
    Route::post('vendor/detail', 'Api\VendorController@detail');

    Route::post('vendor/plan/get', 'Api\VendorController@getPlan');
    Route::post('vendor/plan/add-update', 'Api\VendorController@addUpdatePlan');
    Route::post('vendor/plan/delete', 'Api\VendorController@deletePlan');

    Route::post('vendor/product/get', 'Api\ProductController@getProduct');
    Route::post('vendor/product/add-update', 'Api\ProductController@addUpdateProduct');
    Route::post('vendor/product/delete', 'Api\ProductController@deleteProduct');

    Route::post('vendor/profile/update-description', 'Api\VendorController@updateDescription');
    Route::post('vendor/customer-reviews/add', 'Api\VendorController@submitReview');

    Route::post('cart/get', 'Api\CartController@get');
    Route::post('cart/add', 'Api\CartController@add');
    Route::post('cart/remove', 'Api\CartController@remove');
    Route::post('cart/add-to-shortlist', 'Api\CartController@addToShortlist');
    Route::post('cart/add-to-confirm', 'Api\CartController@addToConfirm');
    Route::post('cart/confirm-booking', 'Api\CartController@confirmBooking');

    Route::post('cart/cancel-booking', 'Api\CartController@cancelBooking');
    Route::post('cart/remove-pending', 'Api\CartController@cancelBooking');

    Route::post('cart/payment-token', 'Api\CartController@paymentToken');

    Route::post('update-favorite', 'Api\FavoriteController@updateFavorite')->name('updateFavorite');
    Route::post('remove-favorite', 'Api\FavoriteController@removeFavorite')->name('updateFavorite');
    Route::post('my-favorite', 'Api\FavoriteController@getMyFavorite')->name('myFavorite');
    Route::post('favorite-to-cart', 'Api\FavoriteController@favoriteToCart')->name('favorite-to-cart');

    Route::post('party/planned', 'Api\PartyController@planned')->name('party-planned');
    Route::post('party/previous', 'Api\PartyController@previous')->name('party-previous');
    Route::post('favorite/{id?}', 'Api\FavoriteController@index')->name('favorite-list');

    Route::post('notification-update', 'Api\NotificationController@update')->name('notification-update');
    Route::post('notification-get', 'Api\NotificationController@get')->name('notification-get');
    Route::post('notification-detail', 'Api\NotificationController@detail')->name('notification-detail');

    Route::post('send-notification', 'Api\NotificationController@sendNotification')->name('send-notification');
});
