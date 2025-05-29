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
                        <option value="cancelled" {{ ($request->status === 'cancelled' ? 'selected' : '') }}>Cancelando
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
                            <th>Data da Compra e Atualização</th>
                            <th>Categoria</th>
                            <th>Serviço (ID)</th>
                            <th>Quantidade (Padrão)</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Rede Social</th>
                            <th>Quantidade (Comprada)</th>
                            <th>Pedido Pai</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->id }} {{$purchase->type_purchase}}</td>
                            <td>{{ date('d/m/Y H:i',strtotime($purchase->created_at)) }} {{ date('d/m/Y H:i',strtotime($purchase->updated_at)) }}</td>
                            <td>{{ $purchase->plan->category->title }}</td>
                            <td>{{ $purchase->plan->title }} ({{ $purchase->plan->id_provedor }})</td>
                            <td>{{ $purchase->plan->quantity_min ?? $purchase->plan->quantity_min }}</td>
                            <td>{{ $purchase->email }}</td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace("/[^0-9]/", "", $purchase->telefone) }}" style="color:#727E8C;">{{$purchase->telefone}}</a>
                            </td>
                            <td>{{ $purchase->profile }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>{{ $purchase->purchase_pai_id }}</td>
                            <td>R$ {{ $purchase->convert_price }}</td>
                            <td>
                                @if( $purchase->status == 'approved' )
                                    <span class="badge bg-warning" style="color: #fff;">
                                        Pagamento Aprovado
                                    </span>
                                    <!--<span class="badge bg-success col-lg my-2" style="color: #fff;">-->
                                    <!--    <a href="https://www.seguirplay.com/api_dashboard/{{$purchase->id}}">Enviar para a API</span>-->
                                    <form action="{{ route('web.api_dashboard', $purchase->id) }}" method="GET" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-success"style=" border: none;padding: 5px;margin-top:5px !important; margin: auto;border-radius: 10px;width: 100%;">Enviar para a API</button>
                                    </form>
                                @elseif( $purchase->status  == 'send' )
                                    <span class="badge bg-success"  style="color: #fff;">
                                        Enviado para a API
                                    </span>
                                    <span class="badge bg-danger col-lg my-2"
                                      data-toggle="modal" data-target="#delete"
                                      data-action="{{ route('dashboard.purchases.destroy', ['purchase_id' => $purchase->id]) }}"
                                      style="color: #fff; cursor: pointer;">Apagar</span>
                                @elseif( $purchase->status  == 'erro' )

                                    <span class="badge bg-warning w-100" style="color: #fff;">
                                        Erro
                                    </span>
                                    
                                    <button type="button" class='btn-light mt-2' 
                                    data-action="{{ route('dashboard.purchases.update', ['purchase_id' => $purchase->id]) }}"
                                    onclick="editPedido({{$purchase->id}})"
                                    style=" border: none;padding: 5px;margin: auto;border-radius: 10px;width: 100%;">Editar pedido</button>

                                    <!--<span class="badge bg-success col-lg my-2" style="color: #fff;">-->
                                        
                                    <!--<a href="https://www.seguirplay.com/api_dashboard_reembolsado/{{$purchase->id}}" style="color: #fff;">Reenviar para a API-->
                                    <!--</span>-->
                                     <form action="{{ route('web.api_dashboard_reembolsado', $purchase->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-success"style=" border: none;padding: 5px;margin-top:5px !important; margin: auto;border-radius: 10px;width: 100%;">Reenviar pedido</button>
                                    </form>

                                @elseif( $purchase->status  == 'pending' )
                                    <form action="{{ route('dashboard.purchases.approved', ['purchase_id' => $purchase->id]) }}" method="get" id="formApproval_{{$purchase->id}}" >
                                        @csrf
                                        <button type="button" class='btn btn-outline-success' onclick="confirmApproval({{$purchase->id}})">Aprovar Pagamento</button>
                                    </form>                                    
                                @elseif( $purchase->status  == 'refunded' )
                                    <span class="badge bg-danger" style="color: #fff;">
                                        Reembolsado
                                    </span>
                                @else
                                    <span class="badge bg-warning" style="color: #fff;">
                                        {{$purchase->status}}
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

    {{-- modal para edição da compra --}}

    <div class="modal fade text-left" id="editPurchase" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title white" id="myModalLabel120">Editando Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit" method="post" action="purchase/update/">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="purchase_id" id="purchase_id">
                        <div class="form-group">
                            <label for="profile">Link</label>
                            <input type="text" id="profile" name="profile" placeholder="Rede Social" class="form-control" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="quantity">Quantidade</label>
                            <input type="text" id="quantity" name="quantity" placeholder="Quantidade" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="price">Preço</label>
                            <input type="text" id="price" name="price" placeholder="Valor total" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Categoria</label>
                            <select name="category_id" id="category_id" class="form-control" onchange="getServices(this)" required></select>
                        </div>

                        <div class="form-group">
                            <label for="plan_id">Serviço</label>
                            <select name="plan_id" id="plan_id" class="form-control" required></select>
                        </div>

                        <button type="submit" class="btn btn-danger ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Salvar</span>
                        </button>
                    </form>
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
                document.getElementById("formApproval_" + id).submit();
            });
        }

        function getServices(element, plan_id = null)
        {
            $.ajax({
                url: 'categorias/getServices/' + element.value,
                type: 'GET',
                success: function(response) {
                    response = JSON.parse(response);

                    $('#plan_id').empty();
                    $('#plan_id').append('<option value="">Escolha o serviço</option>');

                    response.plans.forEach(function(service) {

                        let selected = '';
                        if(service.id == plan_id) {
                            selected = 'selected';
                        }

                        $('#plan_id').append('<option value="' + service.id + '" '+selected+'>' + service.title + '</option>');
                    });
                }
            })
            
        }

        function editPedido(id) {

            //pegar os dados do pedidos e trazer as categorias e servicos disponiveis
            $.ajax({
                url: 'purchase/edit/' + id,
                type: 'GET',
                success: function(response) {
                    
                    response = JSON.parse(response);

                    console.log(response.plan);
                    let category_id = response.plan.category_id;
                    
                    $("#profile").val(response.purchase.profile);
                    $("#quantity").val(response.purchase.quantity);
                    $("#price").val(response.purchase.price);

                    $('#category_id').empty();
                    $('#category_id').append('<option value="">Escolha a categoria</option>');

                    // Iterar sobre as categorias e adicionar ao select
                    response.categories.forEach(function(category) {

                        let selected = '';
                        if(category.id == category_id) selected = 'selected';
                           

                        $('#category_id').append('<option value="' + category.id + '"  '+selected+'>' + category.title + '</option>');
                    });

                    getServices($("#category_id")[0], response.plan.id);

                    $('#purchase_id').val(id);
                    $('#editPurchase').modal('show');

                }
            });
    
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