@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- filter blogs--}}

        <div class="row search-box">
            <div class="col-md-4">
                <form method="GET" action="{{ route('blog.index') }}">
                    <div class="form-group mb-3">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by title or content"
                            value="{{ request('search') }}"
                        >
                    </div>
                    <div class="form-group mb-3">
                        <input
                            type="text"
                            name="author"
                            class="form-control"
                            placeholder="Filter by author"
                            value="{{ request('author') }}"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </form>
            </div>


            <div class="col-md-8">
                <div class="new-blog">
                    <a href="{{ url('blog/create') }}" class=" btn btn-success">Create Blog</a>
                </div>
                {{-- display blogs--}}
                @foreach ($posts as $post)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->content }}</p>
                            <p class="card-text">
                                <small class="text-muted">Posted by {{ $post->user->name }}
                                    on {{ $post->created_at->toFormattedDateString() }}</small>
                            </p>
                            <p class="card-text"><i class="fa fa-like">{{ $post->likes->count() }} Likes</i></p>
                            <form action="{{ route('blog.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <a href="{{ route('blog.show', $post->id) }}" class="btn btn-primary">details</a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>


        {{ $posts->links() }}
    </div>
@endsection
