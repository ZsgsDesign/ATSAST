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

Route::redirect('/home', '/', 301);

Route::get('/', 'MainController@home')->name('home');

Route::group(['prefix' => 'account'], function () {
    Route::get('/update', 'AccountController@update')->name('account.update');
});

Route::group(['prefix' => 'course'], function () {
    Route::get('/', 'CourseController@index')->name('course');
    Route::get('/{cid}/detail', 'CourseController@detail')->name('course.detail');
    Route::get('{cid}/sign/{syid}', 'CourseController@sign')->name('course.sign');
    Route::get('{cid}/register', 'CourseController@register')->name('course.register');
    Route::get('{cid}/script/{syid}', 'CourseController@script')->name('course.script');
});

Route::group(['prefix' => 'contest'], function () {
    Route::get('/', 'ContestController@index')->name('contest');
});

Route::group(['prefix' => 'handling'], function () {
    Route::get('/', 'HandlingController@index')->name('handling.index');
    Route::get('/cart', 'HandlingController@cart')->name('handling.cart');
    Route::get('/publish', 'HandlingController@publish')->name('handling.publish');
    Route::get('/detail/{itemId}', 'HandlingController@detail')->name('handling.detail');
    Route::get('/order', 'HandlingController@order')->name('handling.order');
    Route::get('/order/create', 'HandlingController@orderCreate')->name('handling.orderCreate');
    Route::get('/order/{orderId}', 'HandlingController@orderDetail')->name('handling.orderDetail');
});

Route::group(['prefix' => 'finance', 'as' => 'finance.', 'middleware' => 'auth'], function () {
    Route::get('/', 'FinanceController@index')->name('index');
    Route::get('/initiate', 'FinanceController@initiate')->name('initiate');
    Route::get('/edit/{id}', 'FinanceController@edit')->name('edit');
    Route::get('/details/{id}', 'FinanceController@details')->name('details');
});

Route::group(['prefix' => 'pb'], function () {
    Route::get('/', 'PastebinController@index')->name('pastebin');
    Route::get('/{code}', 'PastebinController@view')->name('pastebin.view');
});

Route::group(['prefix' => 'system'], function () {
    Route::get('/logs', 'SystemController@logs')->name('system.logs');
    Route::get('/bugs', 'SystemController@bugs')->name('system.bugs');
});

Route::group(['prefix' => 'ajax', 'namespace' => 'ajax', 'as' => 'ajax.'], function () {
    Route::group(['prefix' => 'account'], function () {
        Route::post('updatePassword', 'AccountController@updatePassword')->name('account.updatepassword');
    });

    Route::group(['prefix' => 'pastebin'], function () {
        Route::post('generate', 'PastebinController@generate')->middleware('auth')->name('pastebin.generate');
    });

    Route::group(['prefix' => 'system'], function () {
        Route::post('SubmitBugs', 'SystemController@SubmitBugs')->middleware('auth')->name('pastebin.submitbugs');
    });

    Route::group(['prefix' => 'finance', 'as' => 'finance.', 'middleware' => 'auth'], function () {
        Route::post('/initiate', 'FinanceController@initiate')->name('initiate');
        Route::post('/details', 'FinanceController@details')->name('details');
        Route::post('/edit', 'FinanceController@edit')->name('edit');
    });

    Route::group(['prefix' => 'course'], function () {
        Route::post('sign', 'CourseController@sign')->middleware('auth')->name('ajax.course.sign');
    });
});

Auth::routes();
