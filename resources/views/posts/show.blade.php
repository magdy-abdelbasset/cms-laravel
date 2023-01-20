@extends('layouts.app')
@section('content')
<div class="container">
    <div class="text-center">
        <h2>{{ $post->title }}</h2>
        <img src="{{ $post->image }}" alt="" srcset="">
        <p>
            {{ $post->content }}
        </p>
    </div>
    @foreach ($post->comments as $comment)
    <div class="card">
        <div class="card-body">
            <p>{{ $comment->comment }}</p>
        </div>
    </div>
    @endforeach
    <form action="{{  route('comments.store',$post->id)  }}" method="post">
        @csrf
        <textarea name="comment" class="form-control" id="" cols="30" rows="3"></textarea>
        <div class="float-right mt-3">
            <button class="btn btn-primary">
                Comment
            </button>
        </div>
    </form>
</div>
@endsection