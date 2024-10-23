@extends('layout.app')
@section('title', 'The Post')
@section('content')

<div>
        <h2>My Post</h2>
        @if($posts->isEmpty())
                <p>No Posts available</p>
        @else
        <div class="card">
                @foreach($posts as $post)
                        <section class="card-body">
                                <h2 class='card-title'>{{$post->title}}</h2>
                                <p class="card-text">{{Str::limit($post->content, 100)}}</p>
                                @if($post->image)
                                        @foreach($post->image as $image)
                                        <figure class='card-img-top'>
                                                <img src="{{$image->image}}" alt="Post Image" style="width:20%;">
                                        </figure>
                                        @endforeach
                                @endif
                                <a href="{{route('posts.show', $post->id)}}">Read More</a>
                        </section>
                @endforeach
        </div>
        @endif
</div>

@endsection