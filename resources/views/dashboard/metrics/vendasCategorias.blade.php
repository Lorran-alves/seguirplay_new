@extends('dashboard.templates.master')
@section('title', 'Total de compras')
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
                <form action="{{ route('dashboard.vendasCategorias') }}" class="dataTable-search mb-3 d-flex">
                    
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
                <div class="row">
                    <div class="col-md-6">
                        <h3>Categorias</h3>
                        <table class='table table-striped' id="table1">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Gasto total</th>
                                    <th>Periodo</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->category }}</td>
                                    <td>R$ {{ $purchase->price_total }}</td>
                                    <td>{{ $purchase->period }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h3>Cupons</h3>
                        <table class='table table-striped' id="table1">
                            <thead>
                                <tr>
                                    <th>Cupom</th>
                                    <th>Total gasto</th>
                                    <th>Total desconto</th>
                                    <th>Desconto</th>
                                    <th>Total Compras</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($totalComprasCupons as $cupom)
                                <tr>
                                    <td>{{ $cupom->nome }}</td>
                                    <td>R$ {{ number_format($cupom->preco_total, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($cupom->preco_total - $cupom->preco_desconto, 2, ',', '.') }}</td>
                                    <td>{{ $cupom->desconto}}%</td>
                                    <td>{{ $cupom->total_compras }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection