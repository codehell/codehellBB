<div class="panel panel-default">
    <div class="panel-heading">{{ trans('codehellbb::forum.title.edit_post') }}</div>

    <div class="panel-body">
        <form role="form" method="POST" action="{{ route('posts.update', $post) }}">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PATCH">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" >{{ trans('codehellbb::forum.label.post_title') }}</label>

                <input id="title" type="text" class="form-control"
                       name="title" value="{{ old('title', $post->title) }}">

                @if ($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('development') ? ' has-error' : '' }}">
                <label for="development" class="col-md-4 control-label">
                    {{ trans('codehellbb::forum.label.content') }}
                </label>
            <textarea id="development" class="form-control"
                      rows="10" cols="147" name="development">{{ old('development', $post->content) }}</textarea>
                @if ($errors->has('development'))
                    <span class="help-block">
                    <strong>{{ $errors->first('development') }}</strong>
                </span>
                @endif
            </div>

            <div class="rol">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    {{ trans('codehellbb::forum.button.save') }}
                </button>

                <a class="btn btn-warning" href="{{ route('posts.show', [$post->forum->slug, $post->id]) }}">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    {{ trans('codehellbb::forum.button.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
