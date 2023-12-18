<form action="{{ url('comments') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Comment</label>
        <textarea class="form-control" type="text" name="body" placeholder="Enter your comment" required></textarea>
        <input type="hidden" name="post_id" value="{{ $post->id }}">
    </div>
    <button type="submit" class="btn btn-primary">Leave comment</button>
</form>
