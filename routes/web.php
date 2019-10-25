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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/news','NewsController@index');
Route::get('/create','NewsController@createW')->name('createNews');
Route::post('/create','NewsController@create');
Route::get('/news/{id}','NewsController@show')->name('news');
Route::post('/news/editRate','RatingsController@rate');
Route::post('/news/editComment','CommentController@comment');
Route::post('/delete','NewsController@delete')->name('del');
