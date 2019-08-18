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
});

Route::group(['prefix' => 'contest'], function () {
    Route::get('/', 'ContestController@index')->name('contest');
});

Route::group(['prefix' => 'pb'], function () {
    Route::get('/', 'PastebinController@index')->name('pastebin');
    Route::get('/{code}', 'PastebinController@view')->name('pastebin.view');
});

Route::group(['prefix' => 'system'], function () {
    Route::get('/logs', 'SystemController@logs')->name('system.logs');
    Route::get('/bugs', 'SystemController@bugs')->name('system.bugs');
});

Route::group(['prefix' => 'ajax', 'namespace' => 'ajax'], function () {
    Route::group(['prefix' => 'account'], function () {
        Route::post('updatePassword', 'AccountController@updatePassword')->name('ajax.account.updatepassword');
    });

    Route::group(['prefix' => 'pastebin'], function () {
        Route::post('generate', 'PastebinController@generate')->middleware('auth')->name('ajax.pastebin.generate');
    });

    Route::group(['prefix' => 'system'], function () {
        Route::post('SubmitBugs', 'SystemController@SubmitBugs')->middleware('auth')->name('ajax.pastebin.submitbugs');
    });
});

Auth::routes();
