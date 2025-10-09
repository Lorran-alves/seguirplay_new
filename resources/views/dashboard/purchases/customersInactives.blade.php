@extends('dashboard.templates.master')
@section('title', 'Clientes Inativos')

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
                <form action="{{ route('dashboard.purchases.customersInactives') }}" class="dataTable-search mb-3 d-flex">
                    
                    <select class="form-control w-25" id="basicSelect" name="mes">
                        <option value="">Meses sem comprar</option>
                        @for ($i = 2; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ ($request->mes == $i ? 'selected' : '') }}>
                                {{ $i }} {{ $i === 1 ? 'mês' : 'meses' }}
                            </option>
                        @endfor
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
                            <td>
                                @if( $purchase->status == 'approved' )
                                    <span class="badge bg-warning" style="color: #fff;">
                                        Pagamento Aprovado
                                    </span>
                                    
                                @elseif( $purchase->status  == 'send' )
                                    <span class="badge bg-success"  style="color: #fff;">
                                        Enviado para a API
                                    </span>
                                   
                                @elseif( $purchase->status  == 'erro' )

                                    <span class="badge bg-warning w-100" style="color: #fff;">
                                        Erro
                                    </span>
                                @elseif( $purchase->status  == 'pending' )
                                    <span class="badge bg-warning" style="color: #fff;">
                                        Aguardando Pagamento
                                    </span>                                   
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

@endsection

