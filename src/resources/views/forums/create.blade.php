@extends('codehellbb::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('codehellbb::forum.title.create') }}</div>
                <div class="panel-body">
                    <form  role="form" method="POST" action="{{ route('forums.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">{{  trans('codehellbb::forum.label.name') }}</label>


                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif

                        </div>
                        @include('codehellbb::forums/partials/create_description')
                        <div class="form-group">

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                {{ trans('codehellbb::forum.button.save') }}
                            </button>

                            <a href="{{ route('forums.index') }}" class="btn btn-warning">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                {{ trans('codehellbb::forum.button.cancel') }}
                            </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
