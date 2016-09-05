<div class="form-group  {{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description" class="col-md-4 control-label">{{ trans('codehellbb::forum.title.description') }}</label>

        <textarea id="description" class="form-control"
                  rows="5" name="description">{{ old('description') }}</textarea>
        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif

</div>