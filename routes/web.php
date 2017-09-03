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

Route::get('/', 'HomeController@index')->name('home');

// Article

Route::get('/article', 'ArticleController@authArticle')
    ->name('front.article.list');

Route::get('/article/{slug}', 'ArticleController@authShow')
    ->name('front.article.detail');

Route::get('/article/category/{slug}', 'ArticleController@getByCategory')
    ->name('front.article.by.category');

// Lesson

Route::get('/lesson', 'LessonController@authLesson')
    ->name('front.lesson.list');

Route::get('/lesson/category/{slug}', 'LessonController@getByCategory')
    ->name('front.lesson.by.category');

Route::get('/lesson/{slug}', 'LessonController@authShow')
    ->name('front.lesson.detail');

Route::get('/lesson/{parent}/{slug}', 'LessonController@showVideo')
    ->name('front.lesson.video');

// Auth

Route::get('/auth/register', 'AuthController@getRegister')
    ->name('auth.get.register');

Route::post('/auth/register', 'AuthController@postRegister')
    ->name('auth.post.register');

Route::get('/auth/activation', 'AuthController@activation');

Route::get('/auth', 'AuthController@getLogin')
    ->name('auth.get.login');

Route::post('/auth', 'AuthController@postLogin')
    ->name('auth.post.login');

Route::get('/auth/logout', 'AuthController@logout')
    ->name('auth.logout');

// Account

Route::get('/account', 'AuthController@authGetAccount')
    ->name('front.profile')
    ->middleware('user');

Route::get('/account/update', 'AuthController@authGetUpdate')
    ->name('front.profile.update')
    ->middleware('user');

Route::post('/account/update', 'AuthController@authPostUpdate')
    ->name('front.profile.post.update')
    ->middleware('user');

Route::post('/account/changepassword', 'AuthController@authChangePassword')
    ->name('front.profile.changepassword')
    ->middleware('user');

Route::get('/premium/register/{month}', 'PremiumController@register')
    ->name('premium.register');

Route::get('/premium','PremiumController@get')
    ->name('premium');


Route::prefix('/admin')->group(function () {

    Route::get('', 'HomeController@guestDashboard')
        ->name('admin.dashboard')
    ->middleware('all');

    Route::group(['prefix' => '/article', 'middleware' => 'admin.moderator'], function () {

        Route::get('', 'ArticleController@guestArticle')
            ->name('admin.article.list');

        Route::get('/draft', 'ArticleController@guestArticleDraft')
            ->name('admin.article.draft');

        Route::get('/create', 'ArticleController@getCreate')
            ->name('admin.article.create');

        Route::post('/create', 'ArticleController@store')
            ->name('admin.article.store');

        Route::delete('/{slug}', 'ArticleController@destroy')
            ->name('admin.article.destroy');

        Route::get('/{slug}', 'ArticleController@guestShow')
            ->name('admin.article.update');

        Route::post('/{slug}', 'ArticleController@update')
            ->name('admin.article.update');
    });

    // lesson
    Route::group(['prefix' => '/lesson', 'middleware' => 'admin.educator'], function () {

        Route::get('', 'LessonController@guestLesson')
        ->name('admin.lesson.index');

        Route::get('/draft', 'LessonController@guestLessonDraft')
        ->name('admin.lesson.draft');

        Route::get('/create', 'LessonController@getCreate')
        ->name('admin.lesson.create');

        Route::post('/create', 'LessonController@store')
        ->name('admin.lesson.store');

        Route::delete('/{slug}', 'LessonController@destroy')
        ->name('admin.lesson.destroy');

        Route::post('/{slug}', 'LessonController@update')
        ->name('admin.lesson.update');

        Route::get('/{slug}', 'LessonController@guestShow')
        ->name('admin.lesson.show');

        // lesson part
        Route::get('/{slug}/part', 'LessonPartController@index')
        ->name('admin.lessonpart.index');

        Route::post('/{slug}/part', 'LessonPartController@store')
        ->name('admin.lessonpart.store');

        Route::delete('/{slug}/{slugPart}', 'LessonPartController@destroy')
        ->name('admin.lessonpart.destroy');

        Route::get('/{slug}/{slugPart}/show', 'LessonPartController@show')
        ->name('admin.lessonpart.show');

        Route::post('/{slug}/{slugPart}', 'LessonPartController@update')
        ->name('admin.lessonpart.update');

    });


    Route::get('/profile', 'AuthController@guestShow')
    ->name('admin.user.profile')
    ->middleware('all');

    Route::put('/profile/chagepassword', 'AuthController@guestChangePassword')
    ->name('admin.user.changepassword')
    ->middleware('all');

    Route::put('/profile/update', 'AuthController@guestUpdateProfile')
    ->name('admin.user.updateprofile')
    ->middleware('all');

    // auth (user)
    Route::get('/user', 'AuthController@guestUser')
    ->name('admin.user.index')
    ->middleware('admin');

    Route::delete('/user/{user}', 'AuthController@destroy')
    ->name('admin.user.destroy')
    ->middleware('admin');

    // subcription
    Route::get('/subcription', 'SubcriptionController@listSubcription')
    ->name('admin.subcription.index')
    ->middleware('admin');

    Route::put('/subcription', 'SubcriptionController@updateSubcription')
    ->name('admin.subcription.index')
    ->middleware('admin');

    Route::get('/transaction', 'SubcriptionController@listTransaction')
    ->name('admin.transaction.index')
    ->middleware('admin');

    Route::get('/transaction/{id}', 'SubcriptionController@detailTransaction')
    ->name('admin.transaction.detail')
    ->middleware('admin');

});
