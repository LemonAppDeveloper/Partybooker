<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function () {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    return "Cleared!!!";
});

Route::get('auth/{driver}', 'SocialLoginController@redirectToProvider')->name('social.oauth');
Route::get('auth/{driver}/callback', 'SocialLoginController@handleProviderCallback')->name('social.callback');

Route::get('/', 'HomeController@index');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/social-media-share/{id}','VendorController@ShareWidget');

Route::get('/privacy-policy', 'UserController@privacyPolicy');
Route::get('/terms-of-use', 'UserController@termsOfUse');
Route::get('/internet-security', 'UserController@internetSecurity');
Route::get('/faq', 'UserController@faq');
Route::get('/faq-search', 'UserController@faqSearch')->name('faq.search');


Route::post('/contact-form', 'UserController@contactForm')->name('contact-form');

Route::get('/forgot-password', function () {
    return view('auth/forgot-password');
})->name('forgot-password');
Route::post('/forgot-password', 'Auth\LoginController@forgotPassword');

Route::get('/reset-password/{token}', 'Auth\LoginController@resetPassword')->name('reset-password');
Route::post('/reset-password/{token}', 'Auth\LoginController@resetPassword')->name('reset-password');

Route::get('/vendor_register', function () {
    $vendor_register = 1;
    return view('auth.register', compact('vendor_register'));
})->name('vendor_register');

Route::post('update-favorite', 'FavoriteController@updateFavorite')->name('updateFavorite');


Auth::routes();
Route::get('/discover-old', 'HomeController@indexOld')->name('discoverold');
Route::get('/discover', 'HomeController@index')->name('discover');
Route::post('/discover', 'HomeController@index')->name('discover');
Route::post('/update-location-filter','HomeController@updateLocationFilter');
Route::get('/home', 'HomeController@index')->name('discover');
Route::get('/preferences', 'HomeController@preferences')->name('preferences');
Route::POST('/createEvent', 'HomeController@createEvent')->name('createEvent');
Route::get('/my_party', 'HomeController@myParty')->name('my_party');
Route::get('/view/vendor', 'HomeController@vendors')->name('view.vendor');
Route::post('/event/detail', 'HomeController@eventDetail')->name('event.detail');
Route::post('/event/delete', 'HomeController@eventDelete')->name('event.delete');
Route::post('/event/update', 'HomeController@eventUpdate')->name('event.update');

Route::post('/vendor/detail', 'HomeController@vendorDetail')->name('vendor.detail');
Route::get('/vendor/gallery/{id}', 'VendorController@gallery')->name('vendor.gallery');
Route::post('submitreview', 'VendorController@submitreview')->name('submitreview');
Route::post('get-plan-view', 'VendorController@getPlanView')->name('get-plan-view');
Route::post('get-product-view', 'VendorController@getProductView')->name('get-product-view');


Route::post('/mark-as-read', 'NotificationController@markAsRead')->name('markAsRead');

Route::group(['middleware' => ['auth']], function () {
    Route::post('add-to-cart', 'CartController@add')->name('add-to-cart');
    Route::get('cart/{id}', 'CartController@index')->name('cart');
    Route::get('cart', 'CartController@index')->name('cart');
    Route::post('paymentToken', 'CartController@paymentToken')->name('paymentToken');    
    Route::get('party-confirmed/{id}', 'CartController@partyConfirmed')->name('party-confirmed');
    Route::post('remove-cart', 'CartController@remove')->name('remove-cart');
    Route::post('add-to-shortlist', 'CartController@addToShortlist')->name('add-to-shortlist');
    Route::post('add-to-confirm', 'CartController@addToConfirm')->name('add-to-confirm');
    Route::post('confirm-booking', 'CartController@confirmBooking')->name('confirm-booking');
    Route::post('cancel-booking', 'CartController@cancelBooking')->name('cancel-booking');
    Route::post('remove-pending', 'CartController@cancelBooking')->name('remove-pending');

    Route::post('update-profile', 'UserController@updateProfile')->name('update-profile');
    Route::post('change-password', 'UserController@changePassword')->name('change-password');

    Route::get('party/planned', 'PartyController@planned')->name('party-planned');
    Route::get('party/previous', 'PartyController@previous')->name('party-previous');
    Route::get('favorite/{id?}', 'FavoriteController@index')->name('favorite-list');
    Route::post('favorite-to-cart', 'FavoriteController@favoriteToCart')->name('favorite-to-cart');
    Route::get('setting', 'SettingController@index')->name('setting');

    Route::get('notification', 'NotificationController@index')->name('notification');
    Route::post('notification-update', 'NotificationController@update')->name('notification-update');
});
