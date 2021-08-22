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



if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web', 'cekuser:1']], function(){
	Route::get('admin', function() {
		echo "Selamat Datang admin";

	});
});


Route::group(['middleware' => ['web', 'cekuser:1']], function() {
    Route::resource('user', 'UserController');
    Route::get('user_data/get_data', 'UserController@show');
    Route::GET('user/resume/{id}','UserController@resume')->name('user.resume');
    Route::GET('user/reset/{id}','UserController@reset')->name('user.reset');

    Route::get('simpanan/report', 'SimpananController@report');
    Route::get('simpanan/{id}/struk', 'SimpananController@struk');
    Route::get('kas/report', 'KasController@report');
    Route::get('kas/{id}/struk', 'KasController@struk');
    Route::get('pinjaman/report', 'PinjamanController@report');
    Route::get('pinjaman/{id}/struk', 'PinjamanController@struk');
    Route::post('pinjaman/{id}/strukpembayaran', 'PinjamanController@strukpembayaran')->name('pinjaman.strukpembayaran');
    Route::get('penarikan/report', 'PenarikanController@report');
    Route::get('penarikan/{id}/struk', 'PenarikanController@struk');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('simpanan', 'SimpananController');
    Route::resource('kas', 'KasController');
    Route::resource('nasabah', 'NasabahController');
    Route::resource('penarikan', 'PenarikanController');
    Route::resource('pinjaman', 'PinjamanController');
    Route::resource('bayar', 'BayarController');
    Route::get('laporan/simpanan', 'LaporanController@simpanan');
    Route::get('laporan/penarikan', 'LaporanController@penarikan');
    Route::get('laporan/pinjaman', 'LaporanController@pinjaman');
    Route::resource('laporan', 'LaporanController');


});





Route::get('/err123','HomeController@error')->name('error666');
Route::RESOURCE('profile','ProfilController');

Auth::routes();
Route::RESOURCE('home','HomeController');
Route::get('/home', 'HomeController@index')->name('home');
