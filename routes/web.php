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

use Illuminate\Support\Facades\Route;

Route::redirect('/home', '/', 301);

Route::get('/', 'MainController@home')->name('home');

Route::group(['prefix' => 'account'], function () {
    Route::get('/update', 'AccountController@update')->name('account.update');
    Route::get('/profile', 'AccountController@profile')->middleware('auth')->name('account.profile');
    Route::get('/settings', 'AccountController@settings')->middleware('auth')->name('account.settings');
    Route::get('/contests', 'AccountController@contests')->middleware('auth')->name('account.contests');
});

Route::group(['prefix' => 'course'], function () {
    Route::get('/', 'CourseController@index')->name('course');
    Route::get('add', 'CourseController@add')->middleware('auth')->name('course.add');
    Route::get('{cid}', 'CourseController@detail')->middleware('auth','course.exist')->name('course.detail');
    Route::get('{cid}/detail', 'CourseController@detail')->middleware('auth','course.exist')->name('course.detail');
    Route::get('{cid}/sign/{syid}', 'CourseController@sign')->middleware('auth')->name('course.sign');
    Route::get('{cid}/register', 'CourseController@register')->middleware('auth')->name('course.register');
    Route::get('{cid}/script/{syid}', 'CourseController@script')->middleware('auth','course.exist','course.manage','course.syllabus.exist','course.syllabus.script')->name('course.script');
    Route::get('{cid}/feedback/{syid}', 'CourseController@feedback')->middleware('auth','course.exist','course.syllabus.exist','course.feedback')->name('course.feedback');
    Route::get('{cid}/manage', 'CourseController@manage')->middleware('auth','course.exist','course.manage')->name('course.manage');
    Route::get('{cid}/edit', 'CourseController@edit')->middleware('auth','course.exist','course.manage')->name('course.edit');
    Route::get('{cid}/edit_syllabus/{syid}', 'CourseController@editSyllabus')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editSyllabus');
    Route::get('{cid}/edit_sign/{syid}', 'CourseController@editSign')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editSign');
    Route::get('{cid}/edit_feedback/{syid}', 'CourseController@editFeedback')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editFeedback');
    Route::get('{cid}/edit_video/{syid}', 'CourseController@editVideo')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editVideo');
    Route::get('{cid}/edit_script/{syid}', 'CourseController@editScript')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editScript');
    Route::get('{cid}/view_sign/{syid}', 'CourseController@viewSign')->middleware('auth')->name('course.viewSign');
    Route::get('{cid}/view_register', 'CourseController@viewRegister')->middleware('auth')->name('course.viewRegister');
    Route::get('{cid}/view_feedback/{syid}', 'CourseController@viewFeedback')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.viewFeedback');
    Route::get('{cid}/add_syllabus', 'CourseController@addSyllabus')->middleware('auth','course.exist','course.manage')->name('course.addSyllabus');
});

Route::group(['prefix' => 'contest','as' => 'contest.','namespace' => 'Contest'], function () {
    Route::get('/', 'IndexController@index')->name('index');
    Route::get('/add', 'IndexController@add')->middleware('auth','contest.access.add')->name('add');
    Route::group(['prefix' => 'manage','as' => 'manage.'],function() {
        Route::get('/', 'ManageController@index')->middleware('auth')->name('contest.manage.index');
        Route::get('/{cid}', 'ManageController@detail')->middleware('auth','contest.manage')->name('detail');
        Route::get('/{cid}/edit', 'ManageController@edit')->middleware('auth','contest.manage')->name('edit');
        Route::get('/{cid}/export', 'ManageController@export')->middleware('auth','contest.manage')->name('export');
    });

    Route::get('/{cid}', 'IndexController@detail')->middleware('auth','contest.exist')->name('detail');
    Route::get('/{cid}/detail', 'IndexController@detail')->middleware('auth','contest.exist');
    Route::get('/{cid}/register', 'IndexController@register')->middleware('auth','contest.exist')->name('register');
});

Route::group(['prefix' => 'handling'], function () {
    Route::get('/', 'HandlingController@index')->middleware('auth')->name('handling.index');
    Route::get('/cart', 'HandlingController@cart')->middleware('auth')->name('handling.cart');
    Route::get('/publish', 'HandlingController@publish')->middleware('auth')->name('handling.publish');
    Route::get('/edit/{itemId}', 'HandlingController@edit')->middleware('auth')->name('handling.edit');
    Route::get('/detail/{itemId}', 'HandlingController@detail')->middleware('auth')->name('handling.detail');
    Route::get('/order', 'HandlingController@order')->middleware('auth')->name('handling.order');
    Route::get('/order/create', 'HandlingController@orderCreate')->middleware('auth')->name('handling.orderCreate');
    Route::get('/order/{orderId}', 'HandlingController@orderDetail')->middleware('auth')->name('handling.orderDetail');
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
    Route::get('/logs', 'SystemController@logs')->middleware('auth')->name('system.logs');
    Route::get('/bugs', 'SystemController@bugs')->middleware('auth')->name('system.bugs');
});

Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax', 'as' => 'ajax.'], function () {
    Route::group(['prefix' => 'account'], function () {
        Route::post('updatePassword', 'AccountController@updatePassword')->name('account.updatepassword');
        Route::post('updateInfo', 'AccountController@updateInfo')->middleware('auth')->name('account.updateInfo');
        Route::post('sendActivateEmail', 'AccountController@sendActivateEmail')->middleware('auth')->name('account.sendActivateEmail');
        Route::post('changePassword', 'AccountController@changePassword')->name('account.changePassword');
        Route::post('applyAlbum', 'AccountController@applyAlbum')->middleware('auth')->name('account.applyAlbum');
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
        Route::post('/approval', 'FinanceController@approval')->name('approval');
        Route::post('/hang', 'FinanceController@hang')->name('hang');
        Route::post('/unhang', 'FinanceController@unhang')->name('unhang');
    });

    Route::group(['prefix' => 'course'], function () {
        Route::post('sign', 'CourseController@sign')->middleware('auth')->name('course.sign');
        Route::post('submitFeedBack', 'CourseController@submitFeedBack')->middleware('auth','course.exist','course.syllabus.exist','course.feedback')->name('course.submitFeedBack');
        Route::post('addInstructor', 'CourseController@addInstructor')->middleware('auth')->name('course.addInstructor');
        Route::post('removeInstructor', 'CourseController@removeInstructor')->middleware('auth')->name('course.removeInstructor');
        Route::post('addSyllabusInfo', 'CourseController@addSyllabusInfo')->middleware('auth','course.exist','course.manage')->name('course.addSyllabusInfo');
        Route::post('addCourse', 'CourseController@addCourse')->middleware('auth','course.access.add','organization.exist','course.instructors.email.exist','course.valid.color.logo')->name('course.addCourse');
        Route::post('editSign','CourseController@editSign')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editSign');
        Route::post('editVideo','CourseController@editVideo')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editVideo');
        Route::post('editFeedback','CourseController@editFeedback')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editFeedback');
        Route::post('editSyllabus','CourseController@editSyllabus')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editSyllabus');
        Route::post('editScript','CourseController@editScript')->middleware('auth','course.exist','course.manage','course.syllabus.exist')->name('course.editScript');
    });

    Route::group(['prefix' => 'contest'], function () {
        Route::post('add', 'ContestController@add')->middleware('auth','contest.access.add','organization.exist')->name('contest.add');
        Route::post('register', 'ContestController@register')->middleware('auth')->name('contest.register');
    });

    Route::group(['prefix' => 'handling'], function () {
        Route::post('publishItem', 'HandlingController@publishItem')->middleware('auth')->name('handling.publishitem');
        Route::post('addToCart', 'HandlingController@addToCart')->middleware('auth')->name('handling.addtocart');
        Route::post('removeItem', 'HandlingController@removeItem')->middleware('auth')->name('handling.removeitem');
        Route::post('restoreItem', 'HandlingController@restoreItem')->middleware('auth')->name('handling.restoreitem');
        Route::post('deleteFromCart', 'HandlingController@deleteFromCart')->middleware('auth')->name('handling.deleteFromCart');
        Route::post('createOrder', 'HandlingController@createOrder')->middleware('auth')->name('handling.createOrder');
        Route::post('operateOrder', 'HandlingController@operateOrder')->middleware('auth')->name('handling.operateOrder');
    });
});

Auth::routes();
