@extends('codehellbb::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('codehellbb::forum.title.edit') }}</div>
                <div class="panel-body">

                    <form  class="" role="form" method="POST" action="{{ route('forums.update', $forum->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">{{ trans('codehellbb::forum.title.name') }}</label>

                                <input id="name" type="text" class="form-control" name="name"
                                       value="{{ old('name', $forum->name) }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        </div>
                        @include('codehellbb::forums/partials/edit_description')

                        @include('codehellbb::forums/partials/change_owner')

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-floppy-o" aria-hidden="true"></i>
                                {{ trans('codehellbb::forum.button.update') }}
                            </button>
                            <a href="{{ route('forums.show', $forum->slug) }}" class="btn btn-warning">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                {{ trans('codehellbb::forum.button.cancel') }}
                            </a>

                            <button id="predelete" name="predelete"  type="button" class="btn btn-danger">
                                <i class="fa fa-btn fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ trans('codehellbb::forum.button.delete') }}
                            </button>

                        </div>
                    </form>

                    <form id="delete_form" class="form-horizontal hidden" role="form" method="POST"
                          action="{{ route('forums.destroy', $forum->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <div class="col-md-3 col-md-offset-4">
                            <button id="delete_confirm" type="submit" class="btn btn-danger" name="delete_confirm">
                                <i class="fa fa-btn fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ trans('codehellbb::forum.button.delete_confirmation') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
