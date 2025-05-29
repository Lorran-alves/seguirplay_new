@extends('dashboard.templates.master')
@section('title', 'Dashboard')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <h3>Desempenho Mensal Periodo - {{$period}}</h3>
            
        </div>
        <section class="section">
            
            {{-- <form action="{{ route('dashboard.index') }}" class="dataTable-search mb-3 d-flex">
            
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
            </form> --}}

            <div class="row mb-2">

                <div class="col-12 col-md-6">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de Clientes</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>{{$totalClientes}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de vendas</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>R$ {{ number_format($totalVendas, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </section
@endsection
