@foreach($children as $comment)
<article>
<div class="panel panel-default">
    @include('codehellbb::forums/posts/partials/comments')
    <div class="panel-body">
        <p id="comment_{{ $comment->id }}">{{ $comment->comment }}</p>
        @php($children = hell_find_children($comments, $comment->id))
        @if(! $children->isEmpty())
            @include('codehellbb::forums/posts/partials/children')
        @endif
    </div>
</div>
</article>
@endforeach