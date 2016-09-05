
<div class="form-group{{ $errors->has('owner') ? ' has-error' : '' }}">
    <label for="owner" >{{ trans('codehellbb::forum.title.maker') }}</label>

        <select id="owner" class="form-control" name="owner"
                @if( ! Gate::allows('changeOwner', $forum)) disabled @endif>
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                        {{ old('owner', $forum->user_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('owner'))
        <span class="help-block">
            <strong>{{ $errors->first('owner') }}</strong>
        </span>
        @endif
</div>
