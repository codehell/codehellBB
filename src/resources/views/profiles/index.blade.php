@extends('codehellbb::layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('codehellbb::profiles.title.list') }}</div>

                    <div class="panel-body">
                        @include('codehellbb::partials/alerts')
                        <ul>
                            @foreach($users as $user)
                                <li><a href="{{ route('profiles.edit', $user->id) }}">{{ $user->name }}</a> - {{ $user->skill }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection