<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CommentDataTable;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentDataTable $dataTable)
    {
        //
        return $dataTable->render('partials.index-dataTable',['title'=>"Your Comments"]);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
        $comment->delete();
        return redirect(route('comments.index'))->with('success',"Comment Deleted Success");
    }
    private function handleData($request)
    {
        $data = $request->only('title','content','date');
        return $data;
        # code...
    }
}
