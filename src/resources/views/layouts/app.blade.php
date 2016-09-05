<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Codehell.info</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    @yield('styles')
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
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
                    Codehell.info
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>

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
                            <input id="search" name="search" type="text" class="form-control" placeholder="Search" value="{{ $search or ''}}">
                        </div>
                        <button id="button_search" type="submit" class="btn btn-default">Submit</button>
                    </form>
                    @can('index', auth()->user())
                    <li><a href="{{ route('profiles.index') }}">{{ trans('codehellbb::forum.link.profiles') }}</a></li>
                    @endcan

                    @can('is-admin')
                        <li><a href="{{ url('/logs') }}">Logs</a></li>
                    @endcan
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (auth()->guest())
                        <li><a href="{{ url('/login') }}">{{ trans('codehellbb::forum.link.login') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('codehellbb::forum.link.register') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ auth()->user()->name }} <span class="caret"></span>
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

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="{{ asset('codehell/codehellbb/js/codehellbb.js') }}"></script>
    {{-- <script src="/js/app.js"></script> --}}
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('scripts')
</body>
</html>
