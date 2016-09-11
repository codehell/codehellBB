@extends('codehellbb::layouts.app')

@section('content')

<div class="container">

    @can('edit', $user)
        @include('codehellbb::profiles/partials/edit_name')
    @endcan

    @can('updatePassword', $user)
        @include('codehellbb::profiles/partials/edit_password')
    @endcan

    @can('updateEmail', $user)
        @include('codehellbb::profiles/partials/edit_email')
    @endcan

    @can('updateRole', $user)
        @include('codehellbb::profiles/partials/edit_skill')
    @endcan

    @can('banUser', $user)
        @include('codehellbb::profiles/partials/ban_user')
    @endcan
</div>

@endsection
