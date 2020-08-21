<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function home()
    {
        $articles=Article::latest()->get();

        return view('articles.home',['articles'=>$articles
        ]);

    }
    public function show($id)
    {
        $article=Article::find($id);

        return view('articles.show',['article'=>$article
        ]);
    }
}
