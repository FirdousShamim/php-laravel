<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show ($post)
    {
        $posts = [
                     '1' => 'One',
                     '2' => 'Two'
                ];
            
                if(! array_key_exists($post,$posts)){
                    abort( 404, 'Landed on Null Page');
                }
                return view('post', [
                    'post' => $posts[$post]
                ]);
    }   
}
