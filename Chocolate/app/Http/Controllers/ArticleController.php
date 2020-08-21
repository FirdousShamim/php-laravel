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
    public function show(Article $article)
    {
        

        return view('articles.show',['article'=>$article
        ]);
    }
    public function create()
    {
        return view('articles.create');
    }
    public function store()
    {
        //die('Hello'); 
        //dump(request()->all());
        Article::create($this->validateArticle());

        return redirect('/articles');
    }
    public function edit(Article $article)
    {
        

        return view('articles.edit',compact('article'));
    }
    public function update(Article $article)
    {
        $article->update($this->validateArticle());


        return redirect('/articles/'.$article->id);
    }
    public function destroy()
    {

    }
    protected function validateArticle()
    {
        return request()->validate([
            'title'=>['required','min:3','max:255'],
            'excerpt'=>['required'],
            'body'=>['required']
        ]);
         
    }
}
