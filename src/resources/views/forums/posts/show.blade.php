@extends('codehellbb::layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('codehell/codehellbb/css/parsley.css') }}">
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        @include('codehellbb::forums/partials/forums_list')

        <div class="col-md-7">
            @include('codehellbb::forums/posts/partials/post')
            @include('codehellbb::forums/posts/partials/add_comment')
            @include('codehellbb::forums/posts/partials/comments')
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script src="{{asset('codehell/codehellbb/js/parsley.js')}}"></script>
@endsection