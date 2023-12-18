<div class="alert alert-info">
    {{-- <h4>{{ $comment->user->name }}</h4>
    <p>{{ $comment->body }}</p> --}}
    <p><span style="font-size: 1.5rem">{{ $comment->user->name }}: </span>{{ $comment->body }}</p>
    <small>{{ $comment->created_at->diffForHumans() }}</small>
    @if (auth()->user() && auth()->user()->id === $comment->user_id)
        <form action="{{ url('comments/' . $comment->id) }}" method="POST" class="mb-1">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <textarea class="form-control" type="text" name="body" placeholder="Edit your comment" required>{{ $comment->body }}</textarea>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    @endif
    @if (auth()->check() && (auth()->user()->id === $comment->user_id || auth()->user()->isAdmin))
        <form action="{{ url('comments/' . $comment->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Delete</button>
            </div>
        </form>
    @endif
</div>
