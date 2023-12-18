<div class="alert alert-info">
    <h4>{{ $comment->user->name }}</h4>
    <p>{{ $comment->body }}</p>
    <small>{{ $comment->created_at }}</small>
    @if ((auth()->user() && auth()->user()->id === $comment->user_id) || auth()->user()->isAdmin)
        <form action="{{ url('comments/' . $comment->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Delete</button>
            </div>
        </form>
    @endif
</div>
