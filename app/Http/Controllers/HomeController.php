<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::all();
        return view('home',compact('posts'));
    }
    public function showPost( $id)
    {
        $post = Post::find($id);
        return view('posts.show',compact('post'));
    }
    public function storeComment($id,CommentRequest $request)
    {
        Comment::create([
            "comment" => $request->comment,
            "user_id" => Auth::id(),
            "post_id" => $id ,
            "date"     => Carbon::now()
        ]);
        return redirect(route('posts.show',$id));
    }
}
