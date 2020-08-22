<?php

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

// Route::get('posts/{post}', function ($post) {
//     $posts = [
//          '1' => 'One',
//          '2' => 'Two'
//     ];

//     if(! array_key_exists($post,$posts)){
//         abort( 404, 'Landed on Null Page');
//     }
//     return view('post', [
//         'post' => $posts[$post]
//     ]);
// });
//Route::get('/posts/{post}','PostController@show');

Route::get('/welcome',function() {
    return view('welcome');
});
Route::get('/contact',function() {
    return view('contact');
});
Route::get('/aboutus',function() {
    return view('aboutus',[

        'articles'=> App\Article::take(3)->latest()->get()    
    ]);
});
Route::get('/',function() {
    return view('welcome');
});
Route::get('/articles','ArticleController@home')->name('articles.home');
Route::post('/articles','ArticleController@store');
Route::get('/articles/create','ArticleController@create');
Route::get('/articles/{article}','ArticleController@show')->name('articles.show');
Route::get('/articles/{article}/edit','ArticleController@edit');
Route::put('/articles/{article}','ArticleController@update');