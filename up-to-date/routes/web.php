<?php

use App\Http\Controllers\PlansController;
use App\Http\Controllers\TasksController;
use Illuminate\Console\Scheduling\Schedule;
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
Route::get('/home/plans/{plan}/addCollaborator','PlansController@addCollaborator')->name('plans.addCollab');
Route::post('/home/plans/{plan}/addCollaborator','PlansController@emailCollaborator');
Route::post('/home/plans/schedule','PlansController@schedule');
Route::put('/home/plans/{plan}/delete','PlansController@destroy');


// Route::put('/home/plans/{plan}/complete','PlansController@complete');

Route::post('/home/plans/{plan}','TasksController@store');
Route::get('/home/plans/{plan}/createtask','TasksController@create');
Route::get('/home/plans/{plan}/tasks/{task}/edit', 'TasksController@edit');
Route::put('/home/plans/{plan}/tasks/{task}', 'TasksController@update');
Route::put('/home/plans/{plan}/tasks/{task}/complete','TasksController@complete');
Route::put('/home/plans/{plan}/tasks/{task}/uncomplete','TasksController@uncomplete');
Route::put('/home/plans/{plan}/tasks/{task}/delete','TasksController@destroy');
