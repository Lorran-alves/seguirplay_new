@extends('dashboard.templates.master')
@section('title', 'Categorias')
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

                <a href="{{ route('dashboard.services.create') }}">
                    <button class="btn btn-primary mb-4">Adicionar serviço</button>
                </a>

                <!--<a href="{{ route('dashboard.categories.create') }}">
                    <button class="btn btn-primary mb-4">Adicionar categoria</button>
                </a>-->

                <table class='table table-striped' id="table1">
                    <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Opções</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->title }}</td>
                            <td>
                                <a href="{{ route('dashboard.categories.show', ['category' => $category->id]) }}">
                                    <span class="badge bg-info" style="color: #fff;">Gerenciar serviços</span>
                                </a>
                                <!--<span class="badge bg-danger"
                                      data-toggle="modal" data-target="#delete"
                                      data-action="{{ route('dashboard.categories.destroy', ['category' => $category->id]) }}"
                                      style="color: #fff; cursor: pointer;">Apagar</span>-->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    
    <!--
    <div class="modal fade text-left" id="delete" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Apagar serviço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Você realmente deseja apagar esse serviço? <br>
                    <b>Todas as compras vinculadas a ele serão deletadas</b>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Fechar</span>
                    </button>
                    <form id="formDelete" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Apagar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>-->
@endsection
@push('scripts')
    <script>
        $('#delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var action = button.data('action')
            var modal = $(this)
            modal.find('#formDelete').attr('action', action);
        })
    </script>
@endpush
