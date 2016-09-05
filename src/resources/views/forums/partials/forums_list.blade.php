<div class="col-md-3 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('codehellbb::forum.title.forums') }}</div>
        <div class="panel-body">
            <div class="list-group">
                @foreach($forums as $item)
                    @can('show', $item)

                    <a id="{{ $item->slug }}" href="{{ route('forums.show', $item->slug) }}"

                        @if(hell_act($counter, $new_posts, $item->id))
                            class="list-group-item active"
                        @else
                            class="list-group-item"
                        @endif
                        >{{ $item->name }}
                    </a>

                    @endcan
                @endforeach
            </div>
        </div>

    </div>

    @if(isset($forum))
    <div class="panel panel-default">
        <div class="panel-heading">Forum description</div>

        <div class="panel-body">
            <p>
                {{ $forum->description }}
            </p>
        </div>
    </div>
    @endif
</div>
