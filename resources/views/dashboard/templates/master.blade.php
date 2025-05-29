<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset(mix('dashboard_assets/css/app.css')) }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div id="app">
    <div id="sidebar" class='active'>
        @include('dashboard.includes.header')
    </div>
    <div id="main">
        <nav class="navbar navbar-header navbar-expand navbar-light">
            <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
            <button class="btn navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <div class="avatar mr-1">
                                <img src="https://seguirplay.com/dashboard_assets/images/logo.png" alt="logo">
                            </div>
                            <div class="d-none d-md-block d-lg-inline-block">Seguir Play</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
{{--                            <a class="dropdown-item" href="{{ route('dashboard.users.edit') }}"><i--}}
{{--                                    data-feather="user"></i> Perfil</a>--}}
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('dashboard.auth.logout') }}" class="dropdown-item" method="post">
                                @csrf
                                <button style="background: none;border: none;width: 100%;text-align: left;"
                                        type="submit"><i data-feather="log-out"></i> Sair
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        @yield('content')
        @include('dashboard.includes.footer')
    </div>
</div>
<script src="{{ asset(mix('dashboard_assets/js/scripts.js')) }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@stack('scripts')
</body>
</html>
