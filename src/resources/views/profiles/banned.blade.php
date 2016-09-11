@extends('codehellbb::layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('codehellbb::forum.title.banned_user') }}</div>

                    <div class="panel-body">
                        <h1>{{ trans('codehellbb::forum.banned_user_message') }}</h1>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection