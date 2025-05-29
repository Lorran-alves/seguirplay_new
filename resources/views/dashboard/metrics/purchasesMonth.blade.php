@extends('dashboard.templates.master')
@section('title', 'Total de compras mensais')
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

    <div class="modal fade text-left" id="more" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel1">Ver mais</h5>
                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Fechar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.comprasMensal') }}" class="dataTable-search mb-3 d-flex">
                    
                    <input class="dataTable-input" placeholder="Pesquisar..." value="{{ $request->search }}"
                    type="search" name="search">

                    <select name="period" id="" class="dataTable-input ml-auto w-200">
                    <option value="">Selecione um periodo</option>
                        @foreach ($periods as $p)
                            <option value="{{$p->period}}" 
                                {{$p->period == $request->period ? 'selected': ''}}>{{$p->period}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary ml-1" type="submit">
                        <i data-feather="search" width="20"></i>
                    </button>
                </form>

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
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Total de compras</th>
                            <th>Gasto total</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->email }}</td>
                           <td>
                                <a href="https://wa.me/{{ preg_replace("/[^0-9]/", "", $purchase->telefone) }}" style="color:#727E8C;">{{$purchase->telefone}}</a>
                            </td>
                            <td>{{ $purchase->total_de_compras }}</td>
                            <td>R$ {{ $purchase->price_total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $purchases->appends([
                    'search' => $request->search,
                    'period' => $request->period,
                    'type_payment' => $request->type_payment,
                    'status' => $request->status
                    ])->links() }}
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

    <div class="modal fade text-left" id="aprovar" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Aprovar Pagamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Você realmente deseja aprovar esse pagamento? <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Fechar</span>
                    </button>
                    
                    <button type="button" class="btn btn-danger ml-1" id="confirmApprovalBtn">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Confirmar</span>
                    </button>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

        function confirmApproval(id) {

            // console.log(id);
            $('#aprovar').modal('show');
            $('#confirmApprovalBtn').on('click', function () {
            // Se o usuário confirmar, envie o formulário
                document.getElementById("formApproval_" + id).submit();
            });
            // if (confirm("Tem certeza de que deseja aprovar o pagamento?")) {
            //     // Se o usuário confirmar, envie o formulário
            //     document.getElementById("formApproval_"+id).submit();
            // } else {
            //     // Caso contrário, não faça nada
            //     return false;
            // }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#more').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var action = button.data('action')
            var modal = $(this)

            $.post(action, function (response) {
                modal.find('.modal-body').html(response)
            }, 'html');
        })

        $('#confirm').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var action = button.data('action')
            var modal = $(this)

            modal.find('#formConfirm').attr('action', action);
        })

        $('#edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var action = button.data('action')
            var instagram = button.data('instagram')
            var modal = $(this)

            modal.find('#formEdit').attr('action', action);
            modal.find('#recipient-instagram').val(instagram);
        })
    </script>
@endpush
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