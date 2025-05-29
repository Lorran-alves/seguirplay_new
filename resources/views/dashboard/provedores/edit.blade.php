@extends('dashboard.templates.master')
@section('title', 'Editar Provedores')
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
                    
                    <form class="form form-vertical" method="post" enctype="multipart/form-data"
                          action="{{ route('dashboard.provedores.update', ['id' => $provedor->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" id="name" value="{{ old('Nome') ?? $provedor->name }}" class="form-control" name="name" placeholder="Nome" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="token">Token</label>
                                        <input type="text" id="token" value="{{ old('token') ?? $provedor->token }}" class="form-control" name="token" placeholder="Token" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="url">Lnk</label>
                                        <input type="text" id="url" value="{{ old('url') ?? $provedor->url }}" class="form-control" name="url" placeholder="Lnk" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="valor">Valor</label>
                                        <input type="text" id="valor" value="{{ old('valor') ?? $provedor->valor }}" class="form-control" name="valor" placeholder="Valor" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="1" @if($provedor->status == 1) selected @endif>Ativo</option>
                                            <option value="0" @if($provedor->status == 0) selected @endif>Inativo</option>
            
                                        </select>
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

