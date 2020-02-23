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

Auth::routes();

Route::get('/', 'HomeController@view');
Route::get('/deploywebsite', 'HomeController@deploywebsite');

Route::get('/women-optical/', 'HomeController@ProductPages');
Route::get('/women-optical/{sku}', 'HomeController@ProductDetail');
Route::get('/men-optical/', 'HomeController@ProductPages');
Route::get('/men-optical/{sku}', 'HomeController@ProductDetail');
Route::get('/kids-optical/', 'HomeController@ProductPages');
Route::get('/kids-optical/{sku}', 'HomeController@ProductDetail');

Route::get('/women-sunglasses/', 'HomeController@ProductPages');
Route::get('/women-sunglasses/{sku}', 'HomeController@ProductDetail');
Route::get('/men-sunglasses/', 'HomeController@ProductPages');
Route::get('/men-sunglasses/{sku}', 'HomeController@ProductDetail');
Route::get('/kids-sunglasses/', 'HomeController@ProductPages');
Route::get('/kids-sunglasses/{sku}', 'HomeController@ProductDetail');


Route::get('/locations/', 'HomeController@view');
Route::any('/contactus/', 'HomeController@contactus');
Route::get('/help/', 'HomeController@view');
Route::get('/cart/', 'ShoppingCartController@view');
Route::get('/addcart/{sku}', 'ShoppingCartController@addCart');
Route::get('/cartremove/', 'ShoppingCartController@view');
Route::get('/checkout/', 'ShoppingCartController@checkout');
Route::any('/checkout/shipping/', 'ShoppingCartController@shipping');
Route::any('/checkout/prescription/', 'ShoppingCartController@prescription');
Route::any('/checkout/payment/', 'ShoppingCartController@payment');
Route::any('/checkout/ordercomplete/', 'ShoppingCartController@ordercomplete');

/**
 * Account details
 */
Route::any('/account/uploadprescription/', 'AccountController@uploadPrescription');
Route::any('/account/login/', 'AccountController@login');
Route::any('/account/register/', 'Auth\RegisterController@showRegistrationForm');
Route::any('/account/forgotpassword/', 'AccountController@forgotpassword');
Route::any('/account/resetpassword/', 'AccountController@resetpassword');
Route::get('/account/details/', 'AccountController@details');
Route::get('/account/edit/', 'AccountController@edit');
Route::get('/account/edit-shipping/', 'AccountController@editshipping');
Route::get('/account/logout/', 'AccountController@logout');
Route::get('/account/order-history/{orderid?}/', 'AccountController@history');
Route::get('/account/prescriptions/', 'AccountController@prescriptions');

/**
 * Admin section
 */
Route::any('/admin/', 'AdminController@index');
Route::any('/admin/add', 'AdminController@add');
Route::any('/admin/save', 'AdminController@save');
Route::any('/admin/delete', 'AdminController@delete');
Route::any('/admin/login', 'AdminController@login');


//TEMP
/*Route::any('/temp/', 'HomeController@temp');
Route::any('/temp/save', 'HomeController@tempsave');
Route::any('/temp/getimage', 'HomeController@tempgetimage');
*/