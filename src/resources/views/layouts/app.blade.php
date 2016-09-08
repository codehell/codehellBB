<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    @yield('styles')
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed"
                        data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;<li><a href="{{ url('/home') }}">Home</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ trans('codehellbb::forum.link.forums') }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('forums.index') }}">
                                    <i class="fa fa-btn fa-list-alt" aria-hidden="true"></i>
                                    {{ trans('codehellbb::forum.link.list') }}
                                </a>
                            </li>
                            @can('create-forum')
                                <li>
                                    <a href="{{ route('forums.create') }}">
                                        <i class="fa fa-btn fa-floppy-o" aria-hidden="true"></i>
                                        {{ trans('codehellbb::forum.link.create') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <form role="form" action="{{route('forums.index')}}" method="get" class="navbar-form navbar-left">
                        <div class="form-group">
                            <input id="search" name="search" type="text" class="form-control"
                                   placeholder="Search" value="{{ $search or ''}}">
                        </div>
                        <button id="button_search" type="submit" class="btn btn-default">Submit</button>
                    </form>
                    @can('index', auth()->user())
                        <li>
                            <a href="{{ route('profiles.index') }}">{{ trans('codehellbb::forum.link.profiles') }}</a>
                        </li>
                    @endcan

                    @can('is-admin')
                        <li><a href="{{ url('/logs') }}">Logs</a></li>
                    @endcan
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('profiles.edit', auth()->user()) }}">
                                        <i class="fa fa-btn fa-user" aria-hidden="true"></i>
                                        {{ trans('codehellbb::forum.link.profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @include('codehellbb::partials.alerts')
    @yield('content')

    <script src="{{ asset('/js/app.js') }}"></script>

    @yield('scripts')

    <script src="{{ asset('codehell/codehellbb/js/codehellbb.js') }}"></script>

</body>
</html>
