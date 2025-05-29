<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset(mix('dashboard_assets/css/app.css')) }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body>
<div id="auth">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-12 mx-auto">
                <div class="card pt-4">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <img src="{{ asset('dashboard_assets/images/logo.png') }}" height="48" class='mb-4'>
                            <h3>Entrar</h3>
                            <p>Faça login para continuar</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('dashboard.auth.login') }}" method="post">
                            @csrf
                            <div class="form-group position-relative has-icon-left">
                                <label for="username">Email</label>
                                <div class="position-relative">
                                    <input type="email" class="form-control" value="{{ old('email') }}" id="username"
                                           name="email">
                                    <div class="form-control-icon">
                                        <i data-feather="user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left">
                                <div class="clearfix">
                                    <label for="password">Senha</label>
                                </div>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="password" name="password">
                                    <div class="form-control-icon">
                                        <i data-feather="lock"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">
                                <button class="btn btn-primary float-right">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset(mix('dashboard_assets/js/scripts.js')) }}"></script>
</body>
</html>
