@extends('dashboard.templates.master')
@section('title', 'Provedores')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>@yield('title')</h3>
                    <p class="text-subtitle text-muted">Uma area de @yield('title')</p>
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
    </div>

   
    

    <section class="section">
        <div class="card">
            <div class="card-body">

                <a href="{{ route('dashboard.provedores.create') }}">
                    <button class="btn btn-primary mb-4">Adicionar Provedor</button>
                </a>
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
                <table class='table table-striped' id="table1">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>token</th>
                        <th>link</th>
                        <th>Opções</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($provedores as $provedor)
                        <tr>
                            <td>{{ $provedor->name }}</td>
                            <td>{{ $provedor->token }}</td>
                            <td>{{ $provedor->url }}</td>
                            
                            <td>
                                <a href="{{ route('dashboard.provedores.edit', $provedor->id) }}">
                                    <span class="badge bg-info" style="color: #fff;">Editar</span>
                                </a>
                                @if ( $provedor->status)
                                <span class="badge bg-warning"
                                      data-toggle="modal" data-target="#desactive"
                                      data-action="{{ route('dashboard.provedores.desactive', $provedor->id) }}"
                                      style="color: #fff; cursor: pointer;">Desativar</span>
                                @else
                                <span class="badge bg-success"
                                      data-toggle="modal" data-target="#active"
                                      data-action="{{ route('dashboard.provedores.active', $provedor->id) }}"
                                      style="color: #fff; cursor: pointer;">Ativar</span>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <div class="modal fade text-left" id="desactive" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                
                <div class="modal-body">
                    Você realmente deseja desativar esse serviço? <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Fechar</span>
                    </button>
                    <form id="formDes" method="get">
                        @csrf
                        <button type="submit" class="btn btn-danger ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Desativar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade text-left" id="active" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                
                <div class="modal-body">
                    Você realmente deseja ativar esse serviço? <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Fechar</span>
                    </button>
                    <form id="formAct" method="get">
                        @csrf
                        <button type="submit" class="btn btn-danger ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Ativar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

@endsection
@push('scripts')
    <script>
       $('#desactive').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var action = button.data('action')
            var modal = $(this)
            modal.find('#formDes').attr('action', action);
        })
        $('#active').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var action = button.data('action')
            var modal = $(this)
            modal.find('#formAct').attr('action', action);
        })
    </script>
@endpush
