<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">@lang('navbar.brand')</a>
            <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="navigation" class="right hide-on-med-and-down">
                @auth
                    <li><a href="/">@lang('navbar.homepage')</a></li>
                    <li><a href="{{ route('auctions') }}">@lang('navbar.auctions')</a></li>
                    <li><a href="{{ route('fixedprices') }}">@lang('navbar.fixed_price')</a></li>
                    <li>
                        <a href="#!" class="dropdown-trigger d" data-target="dropdown-config">@lang('navbar.configuration.title')</a>
                        <ul id="dropdown-config" class="dropdown-content">
                            <li><a href="{{ route('notification_index') }}">@lang('navbar.configuration.notifications')</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                        >
                        {{ __('Logout') }}
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    <ul class="sidenav" id="mobile">
        @auth
            <li><a href="/">@lang('navbar.homepage')</a></li>
            <li><a href="{{ route('auctions') }}">@lang('navbar.auctions')</a></li>
            <li><a href="{{ route('fixedprices') }}">@lang('navbar.fixed_price')</a></li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                >
                    {{ __('Logout') }}
                </a>
            </li>
        @endauth
    </ul>
    @yield('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>