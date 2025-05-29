@extends('dashboard.templates.master')
@section('title', 'Editar perfil')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>@yield('title')</h3>
                    <p class="text-subtitle text-muted">@yield('title')</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif

                    <form class="form form-vertical" method="post" action="{{ route('dashboard.users.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" id="name" value="{{ old('name') ?? Auth::user()->name }}"
                                               class="form-control" name="name" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="image">Imagem</label>
                                        <input type="file" id="image" class="form-control" name="image">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" value="{{ old('email') ?? Auth::user()->email }}" id="email"
                                               class="form-control" name="email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="password">Senha</label>
                                        <input type="password" id="password" class="form-control" name="password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn icon icon-left btn-success mt-1">
                            <i data-feather="check-circle"></i>
                            Editar
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
