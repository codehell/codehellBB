<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('codehellbb::profiles.title.edit_name') }}</div>

        <div class="panel-body">
            <form  role="form" method="POST" action="{{ route('profiles.update', $user->id) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">{{ trans('codehellbb::profiles.label.name') }}</label>
                            <input id="name" type="text" class="form-control" name="name"
                                   value="{{ old('name', $user->name) }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                </div>

                <button name="update_name" type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-floppy-o" aria-hidden="true"></i>{{ trans('codehellbb::forum.button.update') }}
                </button>
            </form>
        </div>
    </div>
</div>
