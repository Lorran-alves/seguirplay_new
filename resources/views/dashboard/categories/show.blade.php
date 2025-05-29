@extends('dashboard.templates.master')
@section('title', 'Serviços')
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

                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif

                <table class='table table-striped' id="sortable">
                    <thead>
                    <tr>
                        <th>Título</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Opções</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($plans as $plan)
                        <tr class="sortable-item" data-id="{{ $plan->id }}">
                            <td>{{ $plan->title }}</td>
                            <td>R$ {{ $plan->price }}</td>
                            <td>{{ (!empty($plan->quantity) ? $plan->quantity : $plan->quantity_min) }}</td>
                            <td>
                                <a href="{{ route('dashboard.services.edit', ['plan' => $plan->id]) }}">
                                    <span class="badge bg-info" style="color: #fff;">Editar</span>
                                </a>
                                @if ( $plan->isActive )
                                <span class="badge bg-warning"
                                      data-toggle="modal" data-target="#desactive"
                                      data-action="{{ route('dashboard.services.desactive', ['plan' => $plan->id]) }}"
                                      style="color: #fff; cursor: pointer;">Desativar</span>
                                @else
                                <span class="badge bg-success"
                                      data-toggle="modal" data-target="#active"
                                      data-action="{{ route('dashboard.services.active', ['plan' => $plan->id]) }}"
                                      style="color: #fff; cursor: pointer;">Ativar</span>
                                @endif
                                <!--<span class="badge bg-danger"
                                      data-toggle="modal" data-target="#delete"
                                      data-action="{{ route('dashboard.services.destroy', ['plan' => $plan->id]) }}"
                                      style="color: #fff; cursor: pointer;">Apagar</span>!-->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

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
    </div>


    <div class="modal fade text-left" id="desactive" tabindex="-1" role="dialog"
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
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Apagar serviço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
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
        $('#delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var action = button.data('action')
            var modal = $(this)
            modal.find('#formDelete').attr('action', action);
        })
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {

            // Obtém o token CSRF do meta tag CSRF
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $("#sortable tbody").sortable({
                update: function(event, ui) {
                    var sortedIds = [];
                    $("#sortable tbody tr").each(function() {
                        sortedIds.push($(this).data("id"));
                    });

                    $.ajax({
                        url: "{{ route('dashboard.categories.update') }}",
                        method: "POST",
                        data: {
                            _token: csrfToken,
                            sortedIds: sortedIds
                        },
                        success: function(response) {
                            // console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // console.error(error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
