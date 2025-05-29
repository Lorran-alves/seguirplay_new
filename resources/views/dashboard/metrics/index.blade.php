@extends('dashboard.templates.master')
@section('title', 'Dashboard')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <h3>Desempenho Mensal - {{$period}}</h3>
            
        </div>
        <section class="section">
            
            <form action="{{ route('dashboard.index') }}" class="dataTable-search mb-3 d-flex">
            
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

            <div class="row mb-2">



                <div class="col-12 col-md-4">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Vendas</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>R$ {{ number_format($resultMensal->total_sales, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Lucros</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>R$ {{ number_format($resultMensal->total_sales - $resultMensal->total_expenses, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Despesas</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>R$ {{ number_format($resultMensal->total_expenses, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="row mb-5">
                <canvas id="annualProfitChart" style="width: 100%; height: 500px;"></canvas>
            </div>
        </section>

        <section class="section">
            <div class="row mb-2">
                <div class="col-12 col-md-4">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de clientes</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>{{$totalClientes}}</p>
                                    </div>
                                </div>
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de compras</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>R$ {{ number_format($totalCompras, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de clientes novos</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>{{$resultMensal->new_customers}}</p>
                                    </div>
                                </div>
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de compras</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>R$ {{ number_format($resultMensal->new_customers_purchases, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de clientes antigos</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>{{$resultMensal->old_customers}}</p>
                                    </div>
                                </div>
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de compras</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>R$ {{ number_format($resultMensal->old_customers_purchases, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row mb-2">
                <div class="col-12 col-md-6">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Total de vendas do dia</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>R$ {{ number_format($lucroDiario, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6" style="cursor: pointer;" onclick="reembolsados()">
                    <div class="card card-statistic">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                <div class='px-3 py-3 d-flex justify-content-between'>
                                    <h3 class='card-title'>Reembolsados</h3>
                                    <div class="card-right d-flex align-items-center">
                                        <p>{{$reembolsados->count()}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row mb-2">
                <div class="col-12 col-md-6">
                    <h3 class='card-title text-center'>Mapa clientes Novos</h3>
                    <div class="row mb-5">
                        <div id="regions_div" style="width: 900px; height: 500px;"></div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <h3 class='card-title text-center'>Mapa todos clientes</h3>
                    <div class="row mb-5">
                        <div id="regions_div_all" style="width: 900px; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </section>
        
        <div class="modal fade text-left" id="reembolsados" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content" style="max-height: 400px; overflow: auto;">
                    
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title white" id="myModalLabel120">Pedidos reembolsados</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <table class='table table-striped' id="table1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Telefone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reembolsados as $r)
                                <tr>
                                    <td>{{ $r->purchase->id }}</td>
                                    <td>{{ $r->purchase->email }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ preg_replace("/[^0-9]/", "", $r->purchase->telefone) }}" style="color:#727E8C;">{{$r->purchase->telefone}}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">

        var googleChartData = [
                ['Country', 'Quantidade'],
                ['Brazil', 0],
                ['Acre', 0],
                ['Alagoas', 0],
                ['Amapa', 0],
                ['Amazonas', 0],
                ['Bahia', 0],
                ['Ceara', 0],
                ['Distrito Federal', 0],
                ['Espirito Santo', 0],
                ['Goias', 0],
                ['Maranhao', 0],
                ['Mato Grosso', 0],
                ['Mato Grosso do Sul', 0],
                ['Minas Gerais', 0],
                ['Para', 0],
                ['Paraiba', 0],
                ['Parana', 0],
                ['Pernambuco', 0],
                ['Piaui', 0],
                ['Rio de Janeiro', 0],
                ['Rio Grande do Norte', 0],
                ['Rio Grande do Sul', 0],
                ['Rondonia', 0],
                ['Roraima', 0],
                ['Santa Catarina', 0],
                ['Sao Paulo', 0],
                ['Sergipe', 0],
                ['Tocantins', 0]
            ];

            google.charts.load('current', {
                'packages': ['geochart'],
            });

            google.charts.setOnLoadCallback(drawRegionsMap);
            google.charts.setOnLoadCallback(drawRegionsMapAll);

            function drawRegionsMap() {
                // Preenche os dados do gráfico com os valores passados para a view pela aplicação Laravel
                @foreach($newCustomerAndState as $item)
                    @php
                        $estado = $item['state'];
                        $total = $item['total'];
                    @endphp
                    googleChartData.forEach(function(element, index) {
                        if (element[0] === '{{ $estado }}') {
                            googleChartData[index][1] = {{ $total }};
                        }
                    });
                @endforeach

                var data = google.visualization.arrayToDataTable(googleChartData);

                var options = {
                    region: 'BR',
                    resolution: 'provinces',
                    width: '100%',
                    datalessRegionColor: 'white',
                    enableRegionInteractivity: true,
                    colorAxis: {colors: ['#f34251']}
                };

                var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

                chart.draw(data, options);
            }

            function drawRegionsMapAll() {
                // Preenche os dados do gráfico com os valores passados para a view pela aplicação Laravel
                @foreach($allCustomerAndState as $item)
                    @php
                        $estado = $item['state'];
                        $total = $item['total'];
                    @endphp
                    googleChartData.forEach(function(element, index) {
                        if (element[0] === '{{ $estado }}') {
                            googleChartData[index][1] = {{ $total }};
                        }
                    });
                @endforeach

                var data = google.visualization.arrayToDataTable(googleChartData);

                var options = {
                    region: 'BR',
                    resolution: 'provinces',
                    width: '100%',
                    datalessRegionColor: 'white',
                    enableRegionInteractivity: true,
                    colorAxis: {colors: ['#f34251']}
                };

                var chart = new google.visualization.GeoChart(document.getElementById('regions_div_all'));

                chart.draw(data, options);
            }
    </script>

    <script>
        
        const months = {!! json_encode(array_column($graficoAnual, 'period')) !!}; // Obtém os períodos do banco de dados
        const grossProfitData = {!! json_encode(array_column($graficoAnual, 'total_sales')) !!}; // Vendas brutas para cada período
        const netProfitData = {!! json_encode(array_column($graficoAnual, 'lucro')) !!}; // Lucro líquido para cada período

        // Criando o gráfico
        const ctx = document.getElementById('annualProfitChart').getContext('2d');
        const annualProfitChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Vendas',
                    data: grossProfitData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Lucros',
                    data: netProfitData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true, // Faz o gráfico responsivo
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
            }
        });

        function reembolsados(){
      
            // console.log(id);
            $('#reembolsados').modal('show');

        }

      </script>
@endsection
