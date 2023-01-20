@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('posts.store') }}" enctype='multipart/form-data' method="post">

                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Post Title</label>
                    <input type="text" value="{{old('title',null)  }}" class="form-control" name="title" id="title"
                        placeholder="Enter Post Title">
                </div>
                @error('title')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <div class="mb-3">
                    <label for="date" class="form-label">Post Date</label>
                    <input type="date" class="form-control" value="{{old('date',null)}}" id="date"
                        placeholder="Enter Post Date">
                </div>
                @error('date')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <div class="mb-3">
                    <label for="image" class="form-label">Post Image</label>
                    <input class="form-control" name="image" type="file" id="image" name="image">
                </div>
                @error('image')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <div class="mb-3">
                    <label for="content" class="form-label">Post Content</label>
                    <textarea name="content" class="form-control" id="content"
                        rows="3">{{old('content',null)}}</textarea>
                </div>
                @error('content')
                <div class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
                <div class="text-center">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection