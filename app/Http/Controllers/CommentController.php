<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Comment;

class CommentController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create()
    {
        $comment = new Comment;
        $comment->content = request()->content;
        $comment->article_id = request()->article_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return back()->with('info', 'You created a comment !');
    }
    

    public function delete($id){
        $comment = Comment::find($id);
        if(Gate::allows('comment-delete', $comment))
        {
            $comment->delete();
            return back()->with('info', 'A comment deleted !');
        } else {
            return back()->with('error', 'Unauthorize to delete comment !');
        }


    }
}
