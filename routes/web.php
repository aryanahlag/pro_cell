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

Route::get('/', function () {
    return redirect('/login');
});

// init
Route::get('/init', 'HomeController@init')->name('init');
Route::get('/file/{url}', 'HomeController@file')->name('file');

Route::middleware('auth')->group(function () {
    // admin
    Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

        // dashboard
        Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');

        Route::resource('category', 'CategoryController');
        Route::get('c/data', 'CategoryController@datatables')->name('category.data');

        Route::resource('brand', 'BrandController');
        Route::get('b/data', 'BrandController@datatables')->name('brand.data');
    });
    //employee
    Route::group(['prefix' => '/employee', 'as' => 'employee.', 'middleware' => 'employee'], function () {
        //dashboard
        Route::get('/dashboard', 'EmployeeController@dashboard')->name('dashboard');
    });
});



Auth::routes();

// Route::get('/home', 'HomeController@index');
