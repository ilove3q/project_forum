@extends('layouts.app')
@section('header')
    <link href="{{ asset('css/vendor/tribute.css') }}" rel="stylesheet">
@endsection
@section('content')
    <thread-view inline-template :initial-replies-count="{{$thread->replies_count}}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <img src="{{$thread->creator->avatar_path}}"
                                     alt="{{$thread->creator->name}}" width="25" height="25" class="mr-1">
                                <span class="flex">
                                <a href="{{route('profiles', $thread->creator)}}">{{$thread->creator->name}}</a> a publié:
                                {{$thread->title}}
                            </span>
                                @can('update', $thread)
                                    <form action="{{$thread->path()}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            {{$thread->body}}
                        </div>
                    </div>
                    <replies
                        @added="repliesCount++"
                        @removed="repliesCount--">
                    </replies>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>Cette discussion a été publié {{$thread->created_at->diffForHumans()}} par
                                <a href="#">{{$thread->creator->name}}</a>, et a actuellement <span
                                    v-text="repliesCount"></span>
                                {{Str::plural('commentaire', $thread->replies_count)}}.
                            </p>
                            <p>
                                <subscribe-button :active="{{json_encode($thread->isSubscribedTo)}}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
