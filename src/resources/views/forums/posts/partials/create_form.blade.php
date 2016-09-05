<div class="panel panel-default">
<div class="panel-heading">{{ trans('codehellbb::forum.title.create_post') }}</div>

<div class="panel-body">
    <form role="form" method="POST" action="{{ route('posts.store', $forum) }}">
        {{ csrf_field() }}
        <input id="method" type="hidden" name="_method" value="POST">
    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="title" >{{ trans('codehellbb::forum.label.post_title') }}</label>

            <input id="title" type="text" class="form-control"
                   name="title" value="{{ old('title') }}">

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
                      rows="4" cols="147" name="development">{{ old('development') }}</textarea>
            @if ($errors->has('development'))
                <span class="help-block">
                    <strong>{{ $errors->first('development') }}</strong>
                </span>
            @endif
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-floppy-o" aria-hidden="true"></i>
            {{ trans('codehellbb::forum.button.save') }}
        </button>
        <a href="{{ route('forums.show', $forum->slug) }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            {{ trans('codehellbb::forum.button.cancel') }}
        </a>
    </div>
    </form>
</div>
</div>