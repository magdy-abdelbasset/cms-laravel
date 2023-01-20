@extends('layouts.app')
{{-- @section('page_title') {{ $title ?? null }}@endsection --}}
@section('content')
    @foreach(['danger', 'success'] as $type)
        @if(session()->has($type))
            <div class="alert alert-{{$type}} alert-dismissible fade show alert-show-personal-page font-size-h6" role="alert">
                {{ session($type) }}
                {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
        @endif
    @endforeach
    
    <div class="card card-custom overflow-auto">
        <div class="card-header">
              <h2 class="text-dark text-shadow fw-bolder text-center">{{$title}}</h2> 

        </div>
            <div class="card-body">
    {!! $dataTable->table() !!}
            </div>
    </div>
@endsection
@section('js')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}


@endsection
