@extends('codehellbb::layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            @include('codehellbb::forums/partials/forums_list')
            <div class="col-md-7">
                 @include('codehellbb::forums/partials/posts_list')
            </div>
        </div>

    </div>

@endsection