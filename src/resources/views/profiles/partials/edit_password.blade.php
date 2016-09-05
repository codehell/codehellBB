<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('codehellbb::profiles.title.change_pass') }}</div>

        <div class="panel-body">
            <form  role="form" method="POST" action="{{ route('profiles.password', $user->id) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="old_password">{{ trans('codehellbb::profiles.label.old_pass') }}</label>
                            <input id="old_password" type="password" class="form-control" name="old_password">
                            @if ($errors->has('old_password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">{{ trans('codehellbb::profiles.label.password') }}</label>
                            <input id="password" type="password" class="form-control" name="password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation">
                                {{ trans('codehellbb::profiles.label.password_confirmation') }}</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                   name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button name="update_password" type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-floppy-o" aria-hidden="true"></i>{{ trans('codehellbb::forum.button.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
