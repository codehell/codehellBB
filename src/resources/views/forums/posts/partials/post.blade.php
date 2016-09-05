<article>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <a href="{{ route('forums.show', $forum->slug) }}">
                        {{$forum->name}}
                    </a>
                    / <span style="font-size: 15px">{{ $post->title }}</span>
                </div>
                <div class="col-md-2">
                    {{ $post->user->name }}
                </div>
                <div class="col-md-2">
                    <span class="label label-default">
                        {{ $post->created_at }}
                    </span>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <p>{{ $post->content }}</p>
            <br>
            @can('update', $post)
                <div class="col-md-2">
                    <a href="{{ route('posts.edit', [$forum->slug, $post]) }}" id="edit_post_{{ $post->id }}">
                        {{ trans('codehellbb::forum.link.edit') }}
                    </a>
                </div>
            @endcan
            @can('createPost', $forum)
                <div class="col-md-2">
                    <!-- Button trigger modal -->
                    <a id="reply_post" data-reply="reply-post"
                       data-toggle="modal" data-target="#myModal" role="button">
                        {{ trans('codehellbb::forum.button.add_comment') }}
                    </a>
                </div>
            @endcan
            @can('destroy', $post)
                <div class="col-md-2">
                    <a id="pre_delete_post" role="button">
                        {{ trans('codehellbb::forum.button.delete') }}
                    </a>
                </div>
                <div id="delete_post_div" class="col-md-6 hidden">
                    <form role="form" method="post" action="{{ route('posts.destroy', $post) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        {{ trans('codehellbb::forum.delete_confirmation') }}
                        <button id="cancel_delete_post" type="button" class="btn btn-success">
                            {{ trans('codehellbb::forum.button.no') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ trans('codehellbb::forum.button.yes') }}
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </div>
</article>