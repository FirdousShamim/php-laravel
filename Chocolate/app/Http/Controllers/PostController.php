<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;

class PostController extends Controller
{
    public function show ($slug)
    {
       // $post = DB::table('posts')->where('slug',$slug)->first();
        
       $post= Post :: where('slug',$slug)->firstorfail();

        return view('post', [
            'post' => $post
        ]);
    }   
}
