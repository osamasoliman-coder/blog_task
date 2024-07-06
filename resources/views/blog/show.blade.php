@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $blogPost->title }}</div>

                    <div class="card-body">
                        <p>{{ $blogPost->content }}</p>
                        <p class="text-muted">Posted by {{ $blogPost->user->name }} on {{ $blogPost->created_at->toFormattedDateString() }}</p>
                        @can('update', $blogPost)
                            <a href="{{ route('blog.edit', $blogPost->id) }}" class="btn btn-primary">Edit</a>
                        @endcan
                        @can('delete', $blogPost)
                            <form action="{{ route('blog.destroy', $blogPost->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endcan
                        <p>{{ $blogPost->likes->count() }} Likes</p>
                        <form action="{{ route('blog.like', $blogPost->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Like</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
