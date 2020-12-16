@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h1>
                        {{$profileUser->name}}
                        <small>{{$profileUser->created_at->diffForHumans()}}</small>
                    </h1>
                </div>

                @foreach($threads as $thread)
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="level">
                        <span class="flex">
                            <a href="#">{{ $thread->creator->name }}</a> a publié: {{ $thread->title }}
                        </span>
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="card-body">
                            {{$thread->body}}
                        </div>
                    </div>
                @endforeach
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
