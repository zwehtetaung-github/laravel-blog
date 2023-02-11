<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except([ 'index', 'detail']);
    }


    public function index()
    {
        $data = Article::latest()->paginate(5);

        return view('articles.index', [
            'articles' => $data
        ]);
    }


    public function detail($id)
    {

        $data = Article::find($id);

        return view('articles.detail', [
            'article' => $data
        ]);
    }


    public function delete($id){
        $article = Article::find($id);
        if(Gate::allows('article-delete', $article))
        {
            $article->delete();
            return redirect('/articles')->with('info', 'An article deleted !');
        } else {
            return back()->with('error', 'Unauthorize to delete article !');
        }
    }


    public function edit($id){
        $article = Article::find($id);
        $category = Category::all();
        if(Gate::allows('article-edit', $article))
        {
            return view('articles.edit', [
                'article' => $article,
                'categories' => $category
            ]);
        } else {
            return back()->with('error', 'Unauthorize to edit article !');
        }
    }


    public function update($id)
    {
        $validator = validator(request()->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);

        if($validator->fails()){
            return back()->withErrors($validator); //$errors
        }

        $article = Article::find($id);
        $article->title = request()->title; //best performance than $_POST['title']
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect("/articles/detail/$article->id")->with('info', 'An article edited !');
    }


    public function add()
    {
        $category = Category::all();
        return view('articles.add', [
            'categories' => $category
        ]);
    }


    public function create()
    {
        $validator = validator(request()->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);

        if($validator->fails()){
            return back()->withErrors($validator); //$errors
        }

        $article = new Article();
        $article->title = request()->title; //best performance than $_POST['title']
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect('/articles')->with('info', 'An article created !');
    }
}
