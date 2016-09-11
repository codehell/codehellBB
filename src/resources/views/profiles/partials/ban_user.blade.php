<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('codehellbb::forum.title.ban_user') }}</div>

        <div class="panel-body">
            <form  role="form" method="POST" action="{{ route('profiles.ban_user', $user->id) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group {{ $errors->has('ban_reason') ? ' has-error' : '' }}">
                            <label for="ban_reason">{{ trans('codehellbb::forum.title.ban_reason') }}</label>
                            <input id="ban_reason" type="text" class="form-control" name="ban_reason"
                                   value="{{ old('ban_reason', $user->ban_reason) }}">
                            @if ($errors->has('ban_reason'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ban_reason') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <button name="ban_user" type="submit" class="btn btn-primary">
                    {{ trans('codehellbb::forum.button.ban') }}
                </button>
            </form>
        </div>
    </div>
</div>