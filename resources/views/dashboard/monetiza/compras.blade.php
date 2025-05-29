@extends('dashboard.templates.master')
@section('title', 'Compras')
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

    {{-- Confirm Send --}}
    <div class="modal fade text-left" id="confirm" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmar envio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form method="post" id="formConfirm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p>Você realmente deseja confirmar o envio? (Essa alteração não pode ser desfeita)</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Fechar</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Confirmar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit instagram --}}
    <div class="modal fade text-left" id="edit" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Editar instagram</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form method="post" id="formEdit">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-instagram" class="col-form-label">Instagram</label>
                            <input type="text" class="form-control" id="recipient-instagram" name="instagram" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Fechar</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Editar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.purchases.index') }}" class="dataTable-search mb-3 d-flex">
                    {{-- Status --}}
                    <select class="form-control w-25" id="basicSelect" name="status">
                        <option value="">Todos status</option>
                        <option value="pending" {{ ($request->status === 'pending' ? 'selected' : '') }}>Pendente
                        </option>
                        <option value="approved" {{ ($request->status === 'approved' ? 'selected' : '') }}>Aprovado
                        </option>
                    </select>

                    {{-- Search --}}
                    <input class="dataTable-input ml-auto" placeholder="Pesquisar..." value="{{ $request->search }}"
                           type="search" name="search">
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
                            <th>ID</th>
                            <th>Data</th>
                            <th>Plano</th>
                            <th>Incritos</th>
                            <th>Visualizações</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Link Canal</th>
                            <th>Link vídeo</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($purchases as $purchase)


                        <tr>
                            <td>{{ $purchase->compra_id }}</td>
                            <td>{{ date('d/m/Y',strtotime($purchase->data_compra)) }}</td>
                            <td>{{ $purchase->nome }}</td>
                            <td>{{ $purchase->inscritos}}</td>
                            <td>{{ $purchase->visualizacoes }}</td>
                            <td>{{ $purchase->email }}</td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace("/[^0-9]/", "", $purchase->telefone) }}" style="color:#727E8C;">{{$purchase->telefone}}</a>
                            </td>
                            <td>{{ $purchase->link_canal }}</td>
                            <td>{{ $purchase->link_video }}</td>
                            <td>R$ {{ $purchase->preco }}</td>
                            <td>
                                @if( $purchase->status == 'approved' )
                                    <span class="badge bg-warning" style="color: #fff;">
                                        Aprovado
                                    </span>
                                    <span class="badge bg-success" style="color: #fff;">
                                        <a href="https://monetizeseucanal.seguirplay.com/enviaServicoDashboard.php?compra_id={{$purchase->compra_id}}">Enviar para a api</a>
                                    </span>
                                @elseif( $purchase->status  == 'completo' )
                                    <span class="badge bg-success" style="color: #fff;">
                                        Enviado para a API
                                    </span>
                                    <span class="badge bg-danger col-lg my-2"
                                      data-toggle="modal" data-target="#delete"
                                      data-action="{{ route('dashboard.monetiza.destroy', ['compra_id' => $purchase->compra_id]) }}"
                                      style="color: #fff; cursor: pointer;">Apagar</span>
                                @elseif( $purchase->status  == 'pending' )
                                    <form action="{{ route('dashboard.monetiza.approved', ['compra_id' => $purchase->compra_id]) }}" method="get" id="formApproval_{{$purchase->compra_id}}" >
                                        @csrf
                                        <button type="button" class='btn btn-outline-success' onclick="confirmApproval({{$purchase->compra_id}})">Aprovar Pagamento</button>
                                    </form>
                                @elseif( $purchase->status  == 'metade' )
                            
                                    <span class="badge bg-success" style="color: #fff;">
                                        Serviço incompleto
                                    </span>
                            
                                </form>  
                                                        
                                @elseif( $purchase->status  == 'refunded' )
                                <span class="badge bg-danger" style="color: #fff;">
                                        Reembolsado
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $purchases->appends([
                    'search' => $request->search,
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