<?php

namespace App\Http\Controllers;

use App\Article;
use App\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function home()
    {
        if (request('tag')){
            $articles= Tag::where('name',request('tag'))->firstorfail()->articles;
            
            //return dump($articles);
        }
        else
        {
            $articles=Article::latest()->get();
        }
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
        return view('articles.create',[
            'tags' => Tag::all()
        ]);
    }
    public function store()
    {
        //die('Hello'); 
        //dump(request()->all());
        $this->validateArticle();
        
        $article= new Article(request(['title','excerpt','body']));
        
        $article->user_id=1;
        $article->save();

        $article->tags()->attach(request('tags'));

        return redirect(route('articles.home'));
    }
    public function edit(Article $article)
    {
        

        return view('articles.edit',compact('article'));
    }
    public function update(Article $article)
    {
        $article->update($this->validateArticle());


        return redirect(route('articles.show',$article));
    }
    public function destroy()
    {

    }
    protected function validateArticle()
    {
        return request()->validate([
            'title'=>['required','min:3','max:255'],
            'excerpt'=>['required'],
            'body'=>['required'],
            'tags'=>'exists.tags,id'
        ]);
         
    }
}
