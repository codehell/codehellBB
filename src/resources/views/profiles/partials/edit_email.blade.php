<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('codehellbb::forum.title.change_email') }}</div>

        <div class="panel-body">
            <form  role="form" method="POST" action="{{ route('profiles.email', $user->id) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">{{ trans('codehellbb::forum.label.email') }}</label>
                            <input id="email" type="email" class="form-control" name="email"
                                   value="{{ old('email', $user->email) }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button name="update_email" type="submit" class="btn btn-primary">
                        {{ trans('codehellbb::forum.button.update') }}
                    </button>
                    <a href="{{ route('profiles.send_confirmation_code', $user) }}"
                       class="btn btn-default"
                    >Ask for confirmation email</a>
                </div>
            </form>
        </div>
    </div>
</div>