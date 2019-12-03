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
Route::get('/', function () {
    return redirect('/z/login');
})->name('login');
// custom auth
Route::get("z/login", "AuthController@getLogin")->name("getLogin")->middleware("guest");
Route::post("z/p/login", "AuthController@postLogin")->name("postLogin")->middleware("guest");

Route::get("z/reg", "AuthController@getRegister")->name("getRegister")->middleware("guest");
Route::post("z/p/reg", "AuthController@postRegister")->name("postRegister")->middleware("guest");

Route::get("z/logout", "AuthController@myLogout")->name("myLogout")->middleware("auth");

// init
Route::get('/init', 'HomeController@init')->name('init');

Route::middleware('auth')->group(function () {
    // admin
    Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

        // dashboard
        Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');

        Route::get('generation/stok', 'StockGenerationController@index')->name('stock-generation.index');

        Route::resource('generation', 'GenerationController');

        Route::put('generation/{id}/verify', 'GenerationController@verify')->name('generation.verify');

        Route::resource('generation/{generation}/stock', 'StockController');


        Route::resource('category', 'CategoryController');
        Route::get('c/data', 'CategoryController@datatables')->name('category.data');

        Route::resource('brand', 'BrandController');
        Route::get('b/data', 'BrandController@datatables')->name('brand.data');

        Route::resource('makeEmployee', 'MakeEmController');
    });
    //employee
    Route::group(['prefix' => '/employee', 'as' => 'employee.', 'middleware' => 'employee'], function () {
        //dashboard
        Route::get('/dashboard', 'EmployeeController@dashboard')->name('dashboard');
        // service
        Route::resource('service', 'ServiceController');
        Route::get('s/data', 'ServiceController@datatables')->name('service.data');
        Route::get('service/pay/{service}', 'ServiceController@payForm')->name('service.payForm');
        Route::put('service/pay/{service}', 'ServiceController@payment')->name('service.pay');

        

        // 
        Route::resource('add/{service}/item', 'ItemServiceController');
    });

    Route::resource('card', 'CardController');
    Route::post("create/bar", "CardController@barcodeStore")->name("barcode.store");
    Route::get("print/{limit}", "CardController@print")->name("barcode.print");

    Route::get('/service/lunas', "ServiceController@sudahlunas")->name('service.lunas');
    Route::get('/service/lunas/{service}', "ServiceController@lunasShow")->name('service.show.lunas');
    Route::get('/service/report/{service}', "ServiceController@cetakStruk")->name('service.cetak.lunas');
    Route::get('c/data', 'ServiceController@lunasData')->name('service.lunasdata');
});




// Route::get('/home', 'HomeController@index');
