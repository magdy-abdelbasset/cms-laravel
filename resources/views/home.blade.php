@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach ($posts as $post)
        <div class="col-md-4">

            <div class="card m-3" style="width: 18rem;">
                <img src="{{ $post->image }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->content }}</p>
                    <a href="{{ route('posts.show',$post->id) }}" class="btn btn-primary">Show Post</a>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection