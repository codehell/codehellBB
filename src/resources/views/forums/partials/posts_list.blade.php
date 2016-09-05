<div class="panel panel-default">
<div class="panel-heading">
    <div class="row">
        @if(isset($forum))
            <div class="col-md-9">
                <h4>{{ $forum->name }} ({{ $forum->user()->first()->name }})</h4>
            </div>

                @can('createPost', $forum)
                <a class="btn btn-info" href="{{ route('posts.create', $forum) }}">
                    {{ trans('codehellbb::forum.link.create_post') }}
                </a>
                @endcan

                @can('update', $forum)
                <a class="btn btn-default" href="{{ route('forums.edit', $forum->id) }}">
                    {{ trans('codehellbb::forum.link.edit_forum') }}
                </a>
                @endcan
        @else
            <div class="col-md-8">
                <h4>{{trans('codehellbb::forum.title.latest')}}</h4>
            </div>
        @endif
    </div>
</div>

<div class="panel-body">
    <ul class="list-group">
        @foreach($posts as $post)
            <li class="list-group-item">
                <div class="row">

                    <div class="col-md-10">

                    <a href="{{ route('posts.show', [$post->forum->slug, $post]) }}"
                       id="show_post_{{ $post->id }}">
                        @if(hell_is_new_post($new_posts, $post->id))
                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                        @endif
                        {{ $post->title . " ({$post->user->name})"}}
                    </a>

                    <span class="badge pull-right">
                        {{ hell_unread_comments_counter($counter, $post) }}
                    </span>

                </div>

                    <div class="col-md-2">
                        <span class="label label-default pull-right">{{ $post->created_at->format('d-m-y') }}</span>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
</div>
{{ $posts->links() }}