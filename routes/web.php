<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'NewsController@index');

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/create','NewsController@createView')->name('createNews');
    Route::post('/create','NewsController@createNews');
    Route::post('/news/editRate','RatingsController@rate');
    Route::post('/news/editSub','SubsController@sub');
    Route::post('/news/editComment','CommentController@comment');
    Route::post('/delete','NewsController@deleteNews')->name('del');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/news','NewsController@index');
Route::get('/news/findByTag/{tag}','NewsController@findNewsByTag');
Route::get('/news/findByAuthor/{user}','NewsController@findNewsByAuthor');
Route::get('/news/{id}','NewsController@showArticle')->name('news');

