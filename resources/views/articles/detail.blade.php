@extends("layouts.app")

@section("content");
    <div class="container">

        @if(session("info"))
            <div class="alert alert-info">
                {{ session("info") }}
            </div>
        @endif

        @if(session("error"))
            <div class="alert alert-danger">
                {{ session("error") }}
            </div>
        @endif

            <div class="card mb-3 border-1 border-primary">
                <div class="card-body">
                    <h3>{{ $article->title }}</h3>
                    <small class="text-muted">
                        <b class="text-success">
                            {{ $article->user->name }}
                        </b>
                        {{ $article->created_at->diffForHumans() }}
                        Category: {{ $article->category->name }}
                    </small>
                    <div>{{ $article->body }}</div>
                </div>
            @auth
            @can('article-delete', $article)
                <div class="card-footer">
                    <a href="{{ url("/articles/delete/$article->id") }}" class="btn btn-danger">Delete</a>
            @endcan
            @can('article-edit', $article)
                    <a href="{{ url("/articles/edit/$article->id") }}" class="btn btn-primary">Edit</a>
                </div>
            @endcan
            @endauth
            </div>

            <h4 class="h5 ms-1 mt-5">Comments ({{ count($article->comments )}})</h4>
                <ul class="list-group">
                    @foreach ($article->comments as $comment )
                        <li class="list-group-item">
                            @can('comment-delete', $comment)
                                <a href="{{ url("/comments/delete/$comment->id") }}" class="btn-close float-end"></a>
                            @endcan
                            <div>
                                <small>
                                    <b class="text-success">
                                        {{ $comment->user->name }}
                                    </b>
                                    {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            {{ $comment->content }}
                        </li>
                    @endforeach
                </ul>

            @auth
            <form action="{{ url("/comments/add") }}" method="post">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id}}">
                <textarea name="content" class="form-control my-2"></textarea>
                <button class="btn btn-success">Add Comment</button>
            </form>
            @endauth
    </div>
@endsection
