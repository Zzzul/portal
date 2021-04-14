<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <ul class="navbar-nav ml-auto">
                        @role('audience')
                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('/') ? ' active' : '' }}" href="/">Event</a>
                        </li>
                        @endrole

                        @role('admin')
                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('admin/user') ? ' active' : '' }}"
                                href="{{ route('user.index') }}">User</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('admin/category') ? ' active' : '' }}"
                                href="{{ route('category.index') }}">Category</a>
                        </li>
                        @endrole

                        @role('organizer|admin')
                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('event') ? ' active' : '' }}"
                                href="{{ route('event.index') }}">Event</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('performer') ? ' active' : '' }}"
                                href="{{ route('performer.index') }}">Performer</a>
                        </li>
                        @endrole

                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('login') ? ' active' : '' }}"
                                href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('register') ? ' active' : '' }}"
                                href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a href="{{ route('history') }}" class="dropdown-item">
                                    History events
                                </a>

                                <a href="{{ route('setting') }}" class="dropdown-item">
                                    Setting
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="mb-3">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-12">
                        <hr>
                        <p class="text-center">Made with <i class="fas fa-heart text-danger"></i> by
                            <a href="https://github.com/Zzzul/" target="_blank">Mohammad Zulfahmi</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
