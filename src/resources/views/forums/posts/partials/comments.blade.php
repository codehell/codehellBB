<div class="panel-heading">
    <div class="row">
        <div class="col-md-4">{{ $comment->user->name }}</div>
        <!-- Buttons trigger modal -->
        @can('store', $comment)
        <div class="col-md-1">
            <a data-type="button"  data-reply="reply-comment" role="button"
                    data-toggle="modal" data-target="#myModal" data-comment="{{ $comment->id }}">
                {{ trans('codehellbb::forum.button.add_comment') }}
            </a>
        </div>
        @endcan
        @can('update', $comment)
        <div class="col-md-1">
            <a data-type="button"  data-reply="edit-comment" role="button"
               data-toggle="modal" data-target="#myModal" data-comment="{{ $comment->id }}">
                {{ trans('codehellbb::forum.button.edit') }}
            </a>
        </div>
        @endcan
        @can('destroy', $comment)
        <div class="col-md-1">
            <a data-type="button"  data-reply="destroy-comment" role="button"
               data-toggle="modal" data-target="#myModal" data-comment="{{ $comment->id }}">
                {{ trans('codehellbb::forum.button.delete') }}
            </a>
        </div>
        @endcan
        <div class="col-md-3 pull-right"><span class="label label-default">{{ $comment->created_at }}</span></div>
    </div>
</div>