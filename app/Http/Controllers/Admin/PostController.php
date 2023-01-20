<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PostDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Utils\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostDataTable $dataTable)
    {
        //
        return $dataTable->render('partials.index-dataTable',['title'=>"Your Posts"]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        
        $data = $request->only('title','content','date');
        $data['author'] = Auth::id();
        $post = Post::create($data);
        $this->setFile('posts/',$request->image,$post,'image');
        return redirect(route('posts.index'))->with('success','Data Created Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post,PostRequest $request)
    {
        //
        $post->update($request->only('title','content','date'));
        $this->setFile('posts/',$request->image,$post,'image');
        return redirect(route('posts.index'))->with('success','Data Updated Success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post )
    {
        Comment::where("post_id",$post->id)->delete();
        $post->delete();
        return redirect(route('posts.index'))->with('success','Data Deleted Success');
    }

}
