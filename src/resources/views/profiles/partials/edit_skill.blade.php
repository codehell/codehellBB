<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">Change Role</div>
        <div class="panel-body">

            <form  role="form" method="POST" action="{{ route('profiles.roles', $user->id) }}">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">

                <div class="row">
                    <div class="col-md-8">

                        <div class="form-group{{ $errors->has('skill') ? ' has-error' : '' }}">
                            <label for="skill" >User Role</label>

                            <select id="skill" class="form-control" name="skill">
                                @foreach($skills as $skill => $value)
                                    <option value="{{ $value }}"
                                            {{ old('skill', $user->skill) == $skill ? 'selected' : '' }}>
                                        {{ $skill }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('skill'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('skill') }}</strong>
                                    </span>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <button name="update_skill" type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-floppy-o" aria-hidden="true"></i>Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>