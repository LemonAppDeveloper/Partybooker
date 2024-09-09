<?php

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
Route::middleware(['auth'])->prefix('vendor')->group(function () {
    Route::get('/dashboard', 'VendorController@index')->name('dashboard');
    Route::get('/profile', 'VendorController@profile');
    Route::get('/profile-old', 'VendorController@profileOld');
    Route::post('/updateProfile', 'VendorController@updateProfile')->name('updateProfile');
    Route::post('/updateDescription', 'VendorController@updateDescription')->name('updateDescription');
    Route::post('/changePassword', 'VendorController@changePassword')->name('changePassword');

    Route::post('/updateVendorAttributes', 'VendorController@updateVendorAttributes')->name('updateVendorAttributes');

    Route::post('/addUpdatePlan', 'VendorController@addUpdatePlan')->name('addUpdatePlan');
    Route::post('/getPlan', 'VendorController@getPlan')->name('getPlan');
    Route::post('/getPlanDetail', 'VendorController@getPlanDetail')->name('getPlanDetail');
    Route::post('/deletePlan', 'VendorController@deletePlan')->name('deletePlan');
    Route::post('/deletePlanImage', 'VendorController@deletePlanImage')->name('deletePlanImage');

    Route::get('/gallery', 'GalleryController@index');
    Route::post('/uploadGalleryImage', 'GalleryController@upload')->name('uploadgalleryimage');
    Route::post('/deleteGalleryImage', 'GalleryController@deleteGalleryImage')->name('deleteGalleryImage');

    Route::post('/addUpdateProduct', 'ProductController@addUpdateProduct')->name('addUpdateProduct');
    Route::post('/getProduct', 'ProductController@getProduct')->name('getProduct');
    Route::post('/getProductDetail', 'ProductController@getProductDetail')->name('getProductDetail');
    Route::post('/deleteProductImage', 'ProductController@deleteProductImage')->name('deleteProductImage');

    Route::post('/deleteProduct', 'ProductController@deleteProduct')->name('deleteProduct');

    Route::post('/booking-info', 'BookingController@bookingInfo')->name('booking-info');
    Route::post('/change-booking-status', 'BookingController@changeBookingStatus')->name('change-booking-status'); 
    Route::get('/booking-export', 'BookingController@export')->name('booking-export');

    Route::get('/get-customer-breakdown', 'VendorController@getCustomerBreakdown')->name('get-customer-breakdown');
    Route::get('/get-earning-graph', 'VendorController@getEarningGraph')->name('get-earning-graph');

    Route::resource('booking', 'BookingController');
    Route::resource('customer', 'CustomerController'); 

    Route::get('configration', 'ConfigrationController@index')->name('vender.configration');
    Route::get('configration/notification', 'ConfigrationController@notification')->name('vender.configration.notification');
    Route::get('configration/notification-list', 'ConfigrationController@notificationList')->name('vender.configration.notification.list');
    Route::post('configration/notification', 'ConfigrationController@notification')->name('vender.configration.notification');
    Route::get('configration/cms-list', 'ConfigrationController@cmsList')->name('vender.configration.cms');
    Route::get('configration/cms', 'ConfigrationController@cms')->name('vender.configration.cms.list');
    Route::post('configration/cms', 'ConfigrationController@cms')->name('vender.configration.cms');
    Route::get('configration/faq-list', 'ConfigrationController@faqList')->name('vender.configration.faq');
    Route::get('configration/faq', 'ConfigrationController@faq')->name('vender.configration.faq.list');
    Route::post('configration/faq', 'ConfigrationController@faq')->name('vender.configration.faq');
    Route::post('configration/faq/delete', 'ConfigrationController@faqDelete')->name('vender.configration.faq.delete');
    Route::get('configration/general', 'ConfigrationController@general')->name('vender.configration.general');
    Route::post('configration/general', 'ConfigrationController@general')->name('vender.configration.general');
    Route::get('configration/bank','ConfigrationController@bank')->name('vender.configration.bank');
    Route::post('configration/bank','ConfigrationController@bank')->name('vender.configration.bank');

   Route::post('add-sechedule', 'BookingController@addSechedule')->name('add.sechedule');
   Route::get('sechedule-list', 'BookingController@secheduleList')->name('sechedule-list');
   Route::get('my-schedule', 'BookingController@mySchedule')->name('my-schedule');
   Route::post('make-default-time', 'BookingController@makeDefaultTime')->name('make-default-time');

   Route::get('/review', 'ReviewController@index')->name('review');
});
