<?php

use App\Http\Controllers\PlansController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/plans','PlansController@index')->name('plans.index');
Route::post('/home/plans','PlansController@store');
Route::get('/home/plans/create','PlansController@create');
Route::get('/home/plans/{plan}','PlansController@show')->name('plans.show');
Route::get('/home/plans/{plan}/edit','PlansController@edit');
Route::put('/home/plans/{plan}','PlansController@update');

Route::put('/home/plans/{plan}/complete','PlansController@complete');

Route::get('/home/tasks','TasksController@index')->name('tasks.index');;
Route::post('/home/plans/{plan}','TasksController@store');
Route::get('/home/plans/{plan}/createtask','TasksController@create');