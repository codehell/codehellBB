<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

        <form data-parsley-validate="" id="form-store" role="form" method="POST"
              data-update_action ="{{ route('comments.update', '') }}"
              data-store_action="{{ route('comments.store', $post) }}"
              data-destroy_action="{{ route('comments.destroy', '') }}">
            <input id="method" type="hidden" name="_method" value="POST">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('codehellbb::forum.title.add_comment') }}</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                        <label for="comment" class="col-md-4 control-label">
                            {{ trans('codehellbb::forum.label.content') }}
                        </label>
                        <textarea id="comment" class="form-control" required="" data-parsley-minlength="5"
                                  rows="4" cols="147" name="comment">{{ old('comment') }}</textarea>
                        @if ($errors->has('comment'))
                            <span class="help-block">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{ trans('codehellbb::forum.button.close') }}
                    </button>
                    <button id="add_comment" type="submit" class="btn btn-primary">
                        {{ trans('codehellbb::forum.button.save') }}
                    </button>
                    <button id="destroy_comment" type="submit" class="btn btn-danger hidden">Delete comment</button>
                </div>
            </div>
        </form>
    </div>
</div>
