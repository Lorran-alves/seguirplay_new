@extends('dashboard.templates.master')
@section('title', 'Adicionar Provedor')
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.provedores.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif

                    <form class="form form-vertical" enctype="multipart/form-data" method="post"
                          action="{{ route('dashboard.provedores.create') }}">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title">Nome</label>
                                        <input type="text" id="name" value="{{ old('name') }}" class="form-control" name="name" placeholder="Nome do provedor" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="token">Token</label>
                                        <input type="text" id="token" value="{{ old('token') }}" class="form-control" name="token" placeholder="Token" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="url">Link</label>
                                        <input type="text" id="url" value="{{ old('url') }}" class="form-control" name="url" placeholder="Link" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="valor">Valor</label>
                                        <input type="text" id="valor" value="{{ old('valor') }}" class="form-control" name="valor" placeholder="Valor" required>
                                    </div>
                                </div>
                            
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="1">Ativo</option>
                                            <option value="0">Inativo</option>
            
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <button type="submit" class="btn icon icon-left btn-success mt-1">
                            <i data-feather="check-circle"></i>
                            Adicionar
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

