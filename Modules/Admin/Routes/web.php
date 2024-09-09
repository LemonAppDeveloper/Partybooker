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

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', 'AdminController@index');

    Route::get('/profile', 'AdminController@profile')->name('admin.update-profile');
    Route::post('/profile', 'AdminController@updateProfile')->name('admin.update-profile');
    Route::post('/change-password', 'AdminController@changePassword')->name('admin.change-password');

    Route::post('/change_status', 'AdminController@changeStatus');
    Route::post('/delete', 'AdminController@destroy');
    Route::resource('vendors', 'VendorController');
    Route::resource('users', 'UsersController');
    Route::resource('category', 'CategoryController');

    Route::get('/booking','BookingController@index');
    Route::post('/booking-info/{ready_to_pay?}', 'BookingController@bookingInfo')->name('booking-management-info');

    Route::get('users/export/{type}', 'UsersController@export');

    Route::get('user-info', 'UsersController@userDetail')->name('user-info');
    Route::get('vendor-info', 'VendorController@vendorDetail')->name('vendor-info');
    
    Route::post('/mark-as-paid', 'BookingController@markAsPaid')->name('mark-as-paid');

    Route::get('settings', 'SettingsController@index')->name('admin.settings');
    Route::get('settings/notification', 'SettingsController@notification')->name('admin.settings.notification');
    Route::get('settings/notification-list', 'SettingsController@notificationList')->name('admin.settings.notification.list');
    Route::post('settings/notification', 'SettingsController@notification')->name('admin.settings.notification');
    Route::get('settings/cms-list', 'SettingsController@cmsList')->name('admin.settings.cms');
    Route::get('settings/cms', 'SettingsController@cms')->name('admin.settings.cms.list');
    Route::post('settings/cms', 'SettingsController@cms')->name('admin.settings.cms');
    Route::get('settings/faq-list', 'SettingsController@faqList')->name('admin.settings.faq');
    Route::get('settings/faq', 'SettingsController@faq')->name('admin.settings.faq.list');
    Route::post('settings/faq', 'SettingsController@faq')->name('admin.settings.faq');
    Route::post('settings/faq/delete', 'SettingsController@faqDelete')->name('admin.settings.faq.delete');
    Route::get('settings/general', 'SettingsController@general')->name('admin.settings.general');
    Route::post('settings/general', 'SettingsController@general')->name('admin.settings.general');
});
