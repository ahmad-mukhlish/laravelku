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

Route::get('/', 'LarisController@index');
Route::get('/motor/page/{halaman}', 'LarisController@getMotor');
Route::get('/motor/', 'LarisController@searchMotorByName');
Route::get('/motorBy/', 'LarisController@searchMotorByForm');
Route::get('/artikel/', 'LarisController@artikel');
Route::get('/artikel/{id}', 'LarisController@artikelById');

Route::get('/detail/{no_mesin}', 'LarisController@detail');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/home', 'AdminController@home')->name('homeAdmin');
Route::post('/admin/home/addBanner', 'AdminController@addBanner')->name('addBanner');
Route::post('/admin/home/editBanner', 'AdminController@editBanner')->name('editBanner');
Route::get('/admin/home/deleteBanner/{id}/name/{name}', 'AdminController@deleteBanner');
Route::post('admin/login', 'AdminController@login');
Route::post('admin/logout', 'AdminController@logout');
Route::get('admin/artikel','AdminController@artikel');
Route::post('admin/addArtikel','AdminController@addArtikel');
Route::post('admin/editArtikel','AdminController@editArtikel');
Route::get('/admin/deleteArtikel/{id}/name/{name}', 'AdminController@deleteArtikel');
Route::get('admin/password_status','AdminController@password_status');
Route::post('admin/ubahpassword','AdminController@ubah_password');

Route::post('api/getBannerById/', 'AdminController@getBannerById');
Route::post('api/getArtikelById/', 'AdminController@getArtikelById');

// route api for android
Route::post('api/getMotor', 'ApiController@getMotor');
Route::get('api/getId', 'ApiController@getId');
Route::get('api/getMerk', 'ApiController@getMerk');
Route::get('api/getTipe/{id_merk}', 'ApiController@getTipe');
Route::get('api/getMerkById/{id_merk}/idTipe/{id_tipe}', 'ApiController@getMerkById');


Route::post('api/login', 'ApiController@login');
Route::post('api/addMotor', 'ApiController@addMotor');
Route::post('api/delete', 'ApiController@delete');
Route::post('api/deleteMotor', 'ApiController@deleteMotor');

Route::post('api/updateMotor', 'ApiController@updateMotor');
Route::get('api/detail/{no_mesin}', 'ApiController@getDetail');



Route::get('api/getSales', 'ApiController@getSales');
Route::post('api/addSales', 'ApiController@addSales');
Route::post('api/deleteSales', 'ApiController@deleteSales');
Route::post('api/updateSales', 'ApiController@updateSales');



Route::post('api/addMerk', 'ApiController@addMerk');
Route::post('api/deleteMerk', 'ApiController@deleteMerk');
Route::post('api/updateMerk', 'ApiController@updateMerk');


Route::get('api/getTipeMotor', 'ApiController@getTipeMotor');
Route::post('api/addTipeMotor', 'ApiController@addTipeMotor');
Route::post('api/deleteTipeMotor', 'ApiController@deleteTipeMotor');
Route::post('api/updateTipeMotor', 'ApiController@updateTipeMotor');

Route::get('/privacy','LarisController@privacy');

Route::post('/api/getPendingBeli','ApiController@getPendingBeli');
Route::post('/api/getPendingJual','ApiController@getPendingJual');
Route::post('api/addPendingBeli', 'ApiController@addPendingBeli');
Route::post('api/deletePendingBeli', 'ApiController@deletePendingBeli');
Route::post('api/updatePendingBeli', 'ApiController@updatePendingBeli');

Route::post('api/addPendingJual', 'ApiController@addPendingJual');
Route::post('api/deletePendingJual', 'ApiController@deletePendingJual');
Route::post('api/updatePendingJual', 'ApiController@updatePendingJual');

Route::post('api/getProfile','ApiController@getProfile');
Route::post('api/editProfile','ApiController@editProfile');
Route::post('api/editProfileOwner','ApiController@editProfileOwner');


Route::get('api/getCustomerById/{no_ktp}', 'ApiController@getCustomerById');
Route::post('api/getCustomer', 'ApiController@getCustomer');
Route::post('api/addCustomer', 'ApiController@addCustomer');

Route::get('api/getMotorById/{no_mesin}', 'ApiController@getMotorById');


Route::post('api/mokasWithNoCust', 'ApiController@mokasWithNoCust');
Route::post('api/mokasWithCust', 'ApiController@mokasWithCust');
Route::post('api/mobarWithNoCust', 'ApiController@mobarWithNoCust');
Route::post('api/mobarWithCust', 'ApiController@mobarWithCust');


Route::get('api/getFilterSales', 'ApiController@getFilterSales');

Route::post('api/getTransaksi', 'ApiController@getTransaksi');
Route::post('api/getNamaCustomerAndNoTelp', 'ApiController@getNamaCustomerAndNoTelp');
Route::post('api/getFilteredMotor', 'ApiController@getFilteredMotor');
Route::post('api/getFilteredPendingJual', 'ApiController@getFilteredPendingJual');
Route::post('api/getFilteredPendingBeli', 'ApiController@getFilteredPendingBeli');


Route::post('api/searchCustomer', 'ApiController@searchCustomer');
Route::post('api/searchNoPol', 'ApiController@searchNoPol');
Route::post('api/searchNoMesin', 'ApiController@searchNoMesin');


Route::post('api/searchPendingBeli', 'ApiController@searchPendingBeli');
Route::post('api/searchPendingJual', 'ApiController@searchPendingJual');
Route::post('api/updateCustomer', 'ApiController@updateCustomer');
Route::post('api/motorValidate', 'ApiController@motorValidate');


Route::post('api/searchTipe', 'ApiController@searchTipe');
Route::get('api/getKonfigInsentif', 'ApiController@getKonfigInsentif');
Route::post('api/updateKonfigInsentif', 'ApiController@updateKonfigInsentif');

Route::post('api/getJumlahMobarInsentif', 'ApiController@getJumlahMobarInsentif');
Route::post('api/getJumlahMokasInsentif', 'ApiController@getJumlahMokasInsentif');

Route::post('api/getLain', 'ApiController@getLain');
Route::post('api/getPersentaseMobar', 'ApiController@getPersentaseMobar');
Route::post('api/updateLain', 'ApiController@updateLain');
Route::post('api/updatePersentaseMobar', 'ApiController@updatePersentaseMobar');

Route::post('api/getPersentaseMokas', 'ApiController@getPersentaseMokas');


Route::get('api/getHjmMotor', 'ApiController@getHjmMotor');
